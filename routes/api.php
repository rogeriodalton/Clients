<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiWarning;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        'Clientes' => [
                ['/client' => 'Cadastro de clientes.'],
                ['/country' => 'País divisão política.'],
                ['/state' => 'Estados divisão política.'],
                ['/city' => 'Cidades divisão política.'],
                ['/neighborhood' => 'Bairros utilizados em todo sistema.'],
        ]
    ]);
});

Route::prefix('client')->group(function () {
    $Controllers = 'App\Http\Controllers\ClientController';
    Route::put("/login",           [$Controllers, 'login'  ]);
    Route::get("/{id}",            [$Controllers, 'show'   ]);
    Route::get("/",                [$Controllers, 'index'  ]);
    Route::post("/{id}",           [$Controllers, 'store'  ]);
    Route::post("/",               [$Controllers, 'store'  ]);
    Route::put("/{id}",            [$Controllers, 'update' ]);
    Route::put("/",           [ApiWarning::class, 'warning']);
    Route::delete("/{id}",         [$Controllers, 'destroy']);
    Route::delete("/",        [ApiWarning::class, 'warning']);
});

Route::prefix('country')->group(function () {
    $Controllers = 'App\Http\Controllers\CountryController';
    Route::get("/{id}",            [$Controllers, 'show'   ]);
    Route::get("/",                [$Controllers, 'index'  ]);
    Route::post("/{id}",           [$Controllers, 'store'  ]);
    Route::post("/",               [$Controllers, 'store'  ]);
    Route::put("/{id}",            [$Controllers, 'update' ]);
    Route::put("/",           [ApiWarning::class, 'warning']);
    Route::delete("/{id}",         [$Controllers, 'destroy']);
    Route::delete("/",        [ApiWarning::class, 'warning']);
});

Route::prefix('state')->group(function () {
    $Controllers = 'App\Http\Controllers\StateController';
    Route::get("/{id}",            [$Controllers, 'show'   ]);
    Route::get("/",                [$Controllers, 'index'  ]);
    Route::post("/{id}",           [$Controllers, 'store'  ]);
    Route::post("/",               [$Controllers, 'store'  ]);
    Route::put("/{id}",            [$Controllers, 'update' ]);
    Route::put("/",           [ApiWarning::class, 'warning']);
    Route::delete("/{id}",         [$Controllers, 'destroy']);
    Route::delete("/",        [ApiWarning::class, 'warning']);
});

Route::prefix('city')->group(function () {
    $Controllers = 'App\Http\Controllers\CityController';
    Route::get("/{id}",            [$Controllers, 'show'   ]);
    Route::get("/",                [$Controllers, 'index'  ]);
    Route::post("/{id}",           [$Controllers, 'store'  ]);
    Route::post("/",               [$Controllers, 'store'  ]);
    Route::put("/{id}",            [$Controllers, 'update' ]);
    Route::put("/",           [ApiWarning::class, 'warning']);
    Route::delete("/{id}",         [$Controllers, 'destroy']);
    Route::delete("/",        [ApiWarning::class, 'warning']);
});

Route::prefix('neighborhood')->group(function () {
    $Controllers = 'App\Http\Controllers\NeighborhoodController';
    Route::get("/{id}",            [$Controllers, 'show'   ]);
    Route::get("/",                [$Controllers, 'index'  ]);
    Route::post("/{id}",           [$Controllers, 'store'  ]);
    Route::post("/",               [$Controllers, 'store'  ]);
    Route::put("/{id}",            [$Controllers, 'update' ]);
    Route::put("/",           [ApiWarning::class, 'warning']);
    Route::delete("/{id}",         [$Controllers, 'destroy']);
    Route::delete("/",        [ApiWarning::class, 'warning']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
