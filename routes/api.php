<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\VoyageController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LigneCommandeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController; // تأكد من استيراد الكلاس

// Test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!'
    ]);
});

use App\Http\Controllers\ArticleController;

Route::resource('articles', ArticleController::class);
// API Resources
Route::apiResource('produits', ProduitController::class);
Route::apiResource('voyages', VoyageController::class);
Route::apiResource('commandes', CommandeController::class);
Route::apiResource('ligne-commandes', LigneCommandeController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('paiements', PaiementController::class);
Route::apiResource('transactions', TransactionController::class);
Route::apiResource('utilisateurs', UtilisateurController::class);

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::post('/checkout', [PaiementController::class, 'store']);
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']); // فقط مرة واحدة

Route::middleware('auth:sanctum')->post('/commandes', [CommandeController::class, 'store']);
Route::middleware('auth:sanctum')->get('/utilisateurs', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Token test (for debugging)
Route::get('/token-test', function () {
    $user = User::first();
    return $user->createToken('test-token')->plainTextToken;
});
