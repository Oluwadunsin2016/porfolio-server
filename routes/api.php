<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExpertiseInformationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialInformationController;
use App\Http\Controllers\WorkInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// header('Access-Control-Allow-Origin: *'); 
// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); 
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['cors']], function () {
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('forgottenPassword',[AuthController::class,'forgottenPassword']);
Route::get('createStorageLink',[AuthController::class,'createStorageLink']);
Route::post('verifyCode',[AuthController::class,'verifyCode']);
Route::post('getNewPassword',[AuthController::class,'getNewPassword']);
Route::get('getCurrentUser/{token}',[AuthController::class,'getCurrentUser']);
Route::post('verifyEmail/{token}',[AuthController::class,'verify']);
Route::get('getWorkInformation/{token}',[WorkInformationController::class,'getWorkInformation']);
Route::get('getExpertiseInformation/{token}',[ExpertiseInformationController::class,'getExpertiseInformation']);
Route::get('getProjects/{token}',[ProjectController::class,'getProjects']);
Route::get('getSocialInformation/{token}',[SocialInformationController::class,'getSocialInformation']);
Route::get('getLanguages/{token}',[LanguageController::class,'getLanguages']);
Route::post('sendMail/{token}',[MailController::class,'sendMail']);
Route::get('download-pdf/{token}',[DownloadController::class,'downloadPdf']);

Route::middleware('auth:sanctum')->group(function (){
Route::post('logout',[AuthController::class,'logout']);
Route::get('getUser',[AuthController::class,'getUser']);
Route::post('updateUser',[AuthController::class,'updateUser']);
Route::post('selfDescription',[AuthController::class,'updateSelfDescription']);
Route::post('uploadCV',[AuthController::class,'uploadCV']);
Route::post('updateProfileImage',[AuthController::class,'updateProfileImage']);
Route::post('updatePassword',[AuthController::class,'updatePassword']);
Route::post('deleteAccount',[AuthController::class,'deleteAccount']);
Route::post('storeSocialInformation',[SocialInformationController::class,'storeSocialInformation']);
Route::post('updateSocialInformation',[SocialInformationController::class,'updateSocialInformation']);
Route::post('storeWorkInformation',[WorkInformationController::class,'storeWorkInformation']);
Route::post('storeExpertiseInformation',[ExpertiseInformationController::class,'storeExpertiseInformation']);
Route::post('updateExpertiseInformation',[ExpertiseInformationController::class,'updateExpertiseInformation']);
Route::post('storeLanguages',[LanguageController::class,'storeLanguages']);
Route::post('updateLanguage',[LanguageController::class,'updateLanguage']);
Route::delete('deleteLanguage/{id}',[LanguageController::class,'deleteLanguage']);
Route::post('storeProject',[ProjectController::class,'storeProject']);
Route::delete('deleteProject/{id}',[ProjectController::class,'deleteProject']);
Route::post('updateProject',[ProjectController::class,'updateProject']);
});
});
