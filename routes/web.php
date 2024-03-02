<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    RoleController,
    SearchController,
    HomeController,
    PermissionController,
    StructureController,
    DocumentController,
    CommentController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// });

// Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
//     Route::get('/', function(){
//         return view('dashboard');
//     });
*/
Route::get('/toogle',[HomeController::class, 'toogle'])->name('toogle');
Route::group(['middleware'=>'auth'],function () {
    Route::get('/', function(){
        return view('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::resource('users',UserController::class);
    Route::get('/users/select/{id}',[UserController::class, 'select_user'])->name('users.get_user');

    Route::resource('roles',RoleController::class);

    Route::resource('comments',CommentController::class);



    Route::resource('documents',DocumentController::class);
    Route::get('/document/select/{id}',[DocumentController::class, 'documentsType'])->name('documents.select_type');
    Route::get('/document/create/{id}',[DocumentController::class, 'add_documentsByType'])->name('documents.createType');
    Route::get('/document/show/{id}',[DocumentController::class, 'showType'])->name('documents.show_document');
    Route::get('/document/edit/{id}',[DocumentController::class, 'editDocument'])->name('documents.edit_document');
    
    Route::get('/document/search/{id}',[SearchController::class, 'search_admin'])->name('documents.search_admin');
    Route::get('/document/delete/{id}',[SearchController::class, 'delete_document'])->name('documents.delete_document');

    Route::resource('structures',StructureController::class);    
    Route::get('/structures/select/leavel/{id}',[StructureController::class, 'select_Level'])->name('structures.select_level');
    Route::get('/structures/select/position/{id}',[StructureController::class, 'select_Positions'])->name('structures.select_position');

    Route::resource('permissions',PermissionController::class);
    Route::get('/permissions/search/{id}',[SearchController::class, 'search_permissions'])->name('permissions.search_permission');
    Route::get('/users/search/{id}',[SearchController::class, 'search_admin'])->name('users.search_admin');

});