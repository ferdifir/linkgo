<?php

use App\Http\Controllers\VillageController;
use App\Http\Controllers\VillageProposalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('village.show');
Route::get('/admin/{page?}', function (Request $request, ?string $page = null) {
    $availablePages = ['dashboard', 'projects', 'budgets', 'proposals', 'requests', 'content', 'media', 'analytics', 'users'];
    $adminPage = $page ?? 'dashboard';
    abort_unless(in_array($adminPage, $availablePages, true), 404);

    $admin = $request->user();
    $villageSlug = (string) ($admin?->village_slug ?? '');
    $villageName = $admin
        ? DB::table('village_pages')->where('slug', $villageSlug)->value('name')
        : null;
    $isAdminAuthenticated = $admin?->is_admin === true
        && $admin->is_active === true
        && $villageName !== null;

    if ($adminPage === 'users' && $isAdminAuthenticated && $admin->admin_role !== 'owner') {
        return redirect()->route('admin.page', ['page' => 'dashboard']);
    }

    return response()->view('admin', [
        'adminPage' => $adminPage,
        'isAdminAuthenticated' => $isAdminAuthenticated,
        'adminVillageName' => $isAdminAuthenticated ? $villageName : 'Administrasi desa',
        'adminVillageSlug' => $isAdminAuthenticated ? $villageSlug : '',
        'canManageUsers' => $isAdminAuthenticated && $admin->admin_role === 'owner',
    ])->header('Cache-Control', 'no-store');
})->name('admin.page');

Route::prefix('api')->group(function () {
    Route::get('/desa/{slug}/content', [VillageController::class, 'villageContent']);
    Route::get('/desa/{slug}/managed-content', [VillageController::class, 'publicManagedContent']);
    Route::post('/desa/{slug}/requests', [VillageController::class, 'storePublicRequest']);
    Route::get('/desa/{slug}/requests/{trackingCode}', [VillageController::class, 'publicRequestStatus']);
    Route::get('/desa/{slug}/budgets', [VillageController::class, 'villageBudgets']);
    Route::post('/desa/{slug}/proposals', [VillageProposalController::class, 'store']);
    Route::post('/login', [VillageController::class, 'login']);
    Route::post('/logout', [VillageController::class, 'logout']);

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/session', [VillageController::class, 'adminSession']);
        Route::get('/analytics', [VillageController::class, 'adminAnalytics']);
        Route::get('/content/{type}', [VillageController::class, 'adminContent']);
        Route::post('/content/{type}', [VillageController::class, 'createContent']);
        Route::put('/content/{type}/{id}', [VillageController::class, 'updateContent']);
        Route::delete('/content/{type}/{id}', [VillageController::class, 'deleteContent']);
        Route::get('/media', [VillageController::class, 'adminMedia']);
        Route::post('/media', [VillageController::class, 'uploadMedia']);
        Route::delete('/media/{id}', [VillageController::class, 'deleteMedia']);
        Route::get('/users', [VillageController::class, 'adminUsers']);
        Route::post('/users', [VillageController::class, 'createAdminUser']);
        Route::put('/users/{id}', [VillageController::class, 'updateAdminUser']);
        Route::get('/requests', [VillageController::class, 'adminRequests']);
        Route::put('/requests/{id}', [VillageController::class, 'updateRequest']);
        Route::get('/proposals', [VillageProposalController::class, 'index']);
        Route::put('/proposals/{id}', [VillageProposalController::class, 'update']);
        Route::delete('/proposals/{id}', [VillageProposalController::class, 'destroy']);

        foreach (['projects', 'budgets'] as $resource) {
            Route::get("/$resource", [VillageController::class, 'admin'.ucfirst($resource)]);
            Route::post("/$resource", [VillageController::class, 'create'.ucfirst(rtrim($resource, 's'))]);
            Route::put("/$resource/{id}", [VillageController::class, 'update'.ucfirst(rtrim($resource, 's'))]);
            Route::delete("/$resource/{id}", [VillageController::class, 'delete'.ucfirst(rtrim($resource, 's'))]);
        }
    });
});
