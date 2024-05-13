<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\App\ProfileController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
       // dd(tenant()->toArray());
        return view('app.welcome');
        // return 'this';

        
    });

    Route::get('/tenant-dashboard', function () {
        return view('app.dashboard');
    })->middleware(['auth', 'verified'])->name('tenant.dashboard');


    // Route::get('test',function(){
    //     return 'login adksafkljdfkl';
    // })->name('test');


    
    Route::middleware('auth')->group(function () {
        Route::get('/tenant.profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
        // Route::patch('/tenant.profile.update', [ProfileController::class, 'update'])->name('tenant.profile.update');
        // Route::delete('/tenant.profile.delete', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');
        // Route::resource('user', TenantsController::class);
    });

   

    require __DIR__.'/tenant-auth.php';

});
