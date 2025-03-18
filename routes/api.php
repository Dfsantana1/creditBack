<?php

use App\Http\Controllers\Credit\CreditDelete;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserList;
use App\Http\Controllers\Media\MediaList;
use App\Http\Controllers\User\UserDelete;
use App\Http\Controllers\User\UserDetail;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\Media\MediaDetail;
use App\Http\Controllers\Media\MediaUpdate;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\MediaEntity\MediaEntityList;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordForgotController;
use App\Http\Controllers\MediaEntity\MediaEntityCreate;
use App\Http\Controllers\MediaEntity\MediaEntityDelete;
use App\Http\Controllers\MediaEntity\MediaEntityDetail;
use App\Http\Controllers\MediaEntity\MediaEntityUpdate;
use App\Http\Controllers\Auth\PasswordTokenCheckController;
use App\Http\Controllers\Credit\CreditDetail;
use App\Http\Controllers\Credit\CreditList;
use App\Http\Controllers\Credit\CreditController;
use App\Http\Controllers\MediaEntity\MediaEntityController;
use App\Http\Controllers\Quota\QuotaController;
use App\Http\Controllers\Quota\QuotaDetail;
use App\Http\Controllers\Quota\QuotaList;

/** Open Routes */
Route::prefix('users')
    ->group(function () {
        Route::get('logout', LogoutController::class);
        Route::post('register', [RegisterUserController::class, 'register']);
        Route::post('login', [LoginUserController::class, 'login']);
        Route::post('password-forgot', PasswordForgotController::class);
        Route::post('password-token-check', PasswordTokenCheckController::class);
        Route::post('password-reset', PasswordResetController::class);
    });

Route::group(['middleware' => ['web']], function () {
    Route::get('/google-auth/callback', [LoginUserController::class, 'externalAuthCallback']);
});



/** No Opened Routes */

/** Mobile Routes with OAuth Token */
Route::middleware(['auth.secure'])->group(function () {
    /** Mobile */
    Route::post('/users/login-by-email', [LoginUserController::class, 'loginByEmail']);
    Route::post('/media/upload-file', [MediaController::class, 'uploadFile']);

    /** Others */
    Route::get('/users/get-by-slug/{hashId}/{userSlug}', [UserController::class, 'getByUserByHashAndSlug']);
    Route::get('/users/get-by-id/{user}', [UserDetail::class, 'show']);
    /** Stories */
});

Route::get('{user}/email-confirmation', [RegisterUserController::class, 'emailConfirmation']);
/** User Routes */
Route::prefix('users')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('get-role-list', [UserController::class, 'getRoleList']);
        Route::get('get-by-session', [UserController::class, 'getBySession']);
        Route::get('get-archived', [UserController::class, 'getArchived']);
        Route::get('{user}/send-email-confirmation', [RegisterUserController::class, 'sendEmailConfirmation']);
        Route::get('{user}/email-confirmation', [RegisterUserController::class, 'emailConfirmation'])->middleware([IsAdmin::class]);

        Route::post('create-internal', [RegisterUserController::class, 'createInternal']);
        Route::post('create-admin', [RegisterUserController::class, 'createAdmin'])->middleware([IsAdmin::class]);
        Route::post('login-by-id', [LoginUserController::class, 'loginById'])->middleware([IsAdmin::class]);
        Route::post('update-password', [UserController::class, 'updatePassword']);
        Route::post('update-role', [UserController::class, 'updateRole']);
        Route::post('update-profile-media', [UserController::class, 'updateProfileMedia']);

        Route::get('/', [UserList::class, 'list']);
        Route::get('/{user}', [UserDetail::class, 'show']);
        Route::delete('/{user}', [UserDelete::class, 'delete']);
        Route::put('/archive/{user}', [UserController::class, 'archive']);
        Route::put('/restore/{user}', [UserController::class, 'restore']);
        Route::put('/{user}', [UserController::class, 'update']);
    });



/** Media Routes */
Route::prefix('media')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/', [MediaList::class, 'list']);
        Route::post('/upload', [MediaController::class, 'uploadFile']);
        Route::post('/upload-file-from-url', [MediaController::class, 'uploadFileFromUrl']);
        Route::post('/encode-image', [MediaController::class, 'encodeImage']);
        Route::post('/create-media-for-aws-url', [MediaController::class, 'createMediaForAWSUrl']);
        Route::delete('/{media}', [MediaController::class, 'delete']);
        Route::get('/{media}', [MediaDetail::class, 'show']);
        Route::put('/{media}', [MediaUpdate::class, 'update']);
        ## User Tags
        Route::post('/add-user-tag', [MediaController::class, 'addUserTag']);
        Route::delete('/delete-user-tag/{mediaUserTag}', [MediaController::class, 'deleteUserTag']);

        //Robin API
        Route::post('/handle-doc', [MediaController::class, 'handleDoc']);
    });

Route::post('upload', [MediaController::class, 'uploadFile']);

/** Media Entity Routes */
Route::prefix('media-entity')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        /** Singleton */
        Route::get('/', [MediaEntityList::class, 'list']);
        Route::post('/', [MediaEntityCreate::class, 'create']);
        Route::get('/{mediaEntity}', [MediaEntityDetail::class, 'show']);
        Route::delete('/{mediaEntity}', [MediaEntityDelete::class, 'delete']);
        Route::put('/{mediaEntity}', [MediaEntityUpdate::class, 'update']);
    });

Route::prefix('media-entities')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('{media}', [MediaEntityController::class, 'getMediaEntitiesByMediaId']);
    });

Route::prefix('helper')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/get-timezone-list', [HelperController::class, 'getTimezoneList']);
        Route::get('/get-timezone-list-with-offset', [HelperController::class, 'getTimezoneWithOffset']);
    });


Route::prefix('credits')
->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/', [CreditController::class, 'store']); 
        Route::get('/', [CreditList::class, 'list']); 
        Route::get('/{credit}', [CreditDetail::class, 'show']); 
        Route::delete('/{credit}', [CreditDelete::class, 'delete']); 
        Route::put('/{credit}', [CreditController::class, 'update']);
    });

Route::prefix('quotas')
->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/', [QuotaController::class, 'store']); 
        Route::get('/{quota}', [QuotaDetail::class, 'show']);
        Route::get('/', [QuotaList::class, 'list']); 
        Route::delete('/{quota}', [QuotaController::class, 'delete']); 
        Route::put('/{quota}', [QuotaController::class, 'update']);
    });

