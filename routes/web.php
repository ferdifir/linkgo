<?php

use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('village.show');
Route::get('/admin', fn () => response()->view('admin')->header('Cache-Control', 'no-store'));

Route::prefix('api')->group(function () {
    Route::get('/desa/{slug}/content', [VillageController::class, 'villageContent']);
    Route::get('/desa/{slug}/managed-content', [VillageController::class, 'publicManagedContent']);
    Route::post('/desa/{slug}/requests', [VillageController::class, 'storePublicRequest']);
    Route::get('/desa/{slug}/requests/{trackingCode}', [VillageController::class, 'publicRequestStatus']);
    Route::get('/desa/{slug}/budgets', [VillageController::class, 'villageBudgets']);
    Route::post('/desa/{slug}/proposals', [VillageController::class, 'submitVillageProposal']);
    Route::get('/auth-config', [VillageController::class, 'authConfig']);
    Route::post('/login', [VillageController::class, 'login']);
    Route::post('/logout', [VillageController::class, 'logout']);

    Route::middleware('admin')->prefix('admin')->group(function () {
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
        foreach (['projects', 'budgets', 'proposals'] as $resource) {
            Route::get("/$resource", [VillageController::class, 'admin'.ucfirst($resource)]);
            if ($resource !== 'proposals') {
                Route::post("/$resource", [VillageController::class, 'create'.ucfirst(rtrim($resource, 's'))]);
            }
            Route::put("/$resource/{id}", [VillageController::class, 'update'.ucfirst(rtrim($resource, 's'))]);
            Route::delete("/$resource/{id}", [VillageController::class, 'delete'.ucfirst(rtrim($resource, 's'))]);
        }
    });
});
