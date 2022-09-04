
<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['can:view admin'])->group(
    function () {
        Route::middleware(['can:edit settings'])->group(
            function () {
                Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'show']);
                Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'save']);
            }
        );
    }
);
