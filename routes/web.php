<?php

use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\TelegramAdminChatWebhookController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\VillageProposalController;
use App\Http\Controllers\WhatsAppAdminChatWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/gending/{slug}', [VillageController::class, 'show'])->name('village.show');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('village.show.alias');
Route::get('/admin/{page?}', function (Request $request, ?string $page = null) {
    if ($page === 'content') {
        return redirect()->route('admin.page', ['page' => 'news']);
    }

    $availablePages = ['dashboard', 'projects', 'budgets', 'proposals', 'requests', 'news', 'activities', 'services', 'officials', 'media', 'analytics', 'users'];
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
    Route::post('/telegram/webhook', TelegramAdminChatWebhookController::class)
        ->middleware('throttle:telegram-webhook')
        ->name('telegram.webhook');
    Route::get('/whatsapp/webhook', [WhatsAppAdminChatWebhookController::class, 'verify'])
        ->name('whatsapp.webhook.verify');
    Route::post('/whatsapp/webhook', [WhatsAppAdminChatWebhookController::class, 'receive'])
        ->middleware('throttle:whatsapp-webhook')
        ->name('whatsapp.webhook.receive');

    Route::get('/desa/{slug}/open-graph', [VillageController::class, 'villageOpenGraph']);
    Route::get('/desa/{slug}/content', [VillageController::class, 'villageContent']);
    Route::get('/desa/{slug}/managed-content', [VillageController::class, 'publicManagedContent']);
    Route::post('/desa/{slug}/requests', [VillageController::class, 'storePublicRequest']);
    Route::get('/desa/{slug}/requests/{trackingCode}', [VillageController::class, 'publicRequestStatus']);
    Route::get('/desa/{slug}/budgets', [VillageController::class, 'villageBudgets']);
    Route::post('/desa/{slug}/proposals', [VillageProposalController::class, 'store']);
    Route::post('/login', [VillageController::class, 'login']);
    Route::post('/logout', [VillageController::class, 'logout']);

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::post('/chat', AdminChatController::class)->middleware('throttle:admin-chat');
        Route::get('/session', [VillageController::class, 'adminSession']);
        Route::get('/analytics', [VillageController::class, 'adminAnalytics']);
        Route::post('/news/draft', [VillageController::class, 'draftNews'])->middleware('throttle:admin-content-ai');
        Route::get('/content/{type}', [VillageController::class, 'adminContent']);
        Route::post('/content/{type}', [VillageController::class, 'createContent']);
        Route::put('/content/{type}/{id}', [VillageController::class, 'updateContent']);
        Route::delete('/content/{type}/{id}', [VillageController::class, 'deleteContent']);
        Route::get('/officials', [VillageController::class, 'adminOfficials']);
        Route::post('/officials', [VillageController::class, 'createOfficial']);
        Route::put('/officials/{id}', [VillageController::class, 'updateOfficial']);
        Route::delete('/officials/{id}', [VillageController::class, 'deleteOfficial']);
        Route::get('/village-head', [VillageController::class, 'adminVillageHead']);
        Route::put('/village-head', [VillageController::class, 'updateVillageHead']);
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
