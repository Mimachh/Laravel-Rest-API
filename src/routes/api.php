<?php

use App\Http\Controllers\Api\Public\Sites\CreateSiteController;
use App\Http\Controllers\Api\Public\Sites\DeleteSiteController;
use App\Http\Controllers\Api\Public\Sites\IndexSiteController;
use App\Http\Controllers\Api\Public\Sites\ShowSiteToUserController;
use App\Http\Controllers\Api\RestoreUserController;
use App\Http\Controllers\Api\SoftDeleteUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UpdatePasswordController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    // return $request->user();
    $user = $request->user();

    // Supposons que vous ayez une relation "roles" dans votre modèle User
    $roles = $user->roles->pluck('name'); // Assurez-vous que "name" correspond au champ de nom de rôle dans votre table de rôles

    return response()->json([
        'user' => $user,
        'roles' => $roles,
    ]);
});


Route::middleware(['auth:sanctum', 'role:1'])->get('/test', function () {
    return response()->json(['message' => 'Ceci est un test']);
});

// User Settings Routes
Route::middleware(['auth:sanctum'])->group(function () {

    Route::put('/user/{id}/password-update/', [
    UpdatePasswordController::class, 'update']);

    Route::put('/user/{id}/avatar/', [
    UserProfileController::class, 'avatar']);
    
    Route::apiResource('/user', 
    UserProfileController::class)->only(['update']);

    Route::delete('/user/{id}/delete/', 
    [SoftDeleteUserController::class, 'softDelete']);

    Route::post('/user/{id}/restore/', 
    [RestoreUserController::class, 'restoreUser']); 
    
    // Route::delete('/user/{id}/forceDelete/', 
    // [::class, 'forceDelete']);

    Route::delete('/user/{id}/avatar-delete/', [
    UserProfileController::class, 'avatarDelete']);

});

// Sites Routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('/site/create', [
    CreateSiteController::class, 'store']); 

    Route::get('/sites/{id}', 
    [ShowSiteToUserController::class, "index"]);

    Route::get('/sites/{id}/{site}', 
    [ShowSiteToUserController::class, "show"]);

    Route::delete('/site/{user}/{site}/delete', 
    [DeleteSiteController::class, "softDelete"]);

});



