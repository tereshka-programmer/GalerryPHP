<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UsersReviewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;
use \App\Http\Controllers\FavouritesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [MainController::class, 'home'])->name('home');


Route::post('/sign-up', [AuthController::class, 'authenticate'])->name('login');

Route::post('sign-up/admin', [AuthController::class, 'authAdmin'])->name('auth.admin');
Route::post('sign-up/author', [AuthController::class, 'authAuthor'])->name('auth.author');
Route::post('sign-up/user', [AuthController::class, 'authUser'])->name('auth.user');

Route::get('/sign-up', [AuthController::class, 'authenticateForm']);


Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
Route::get('/registration', [AuthController::class, 'registrationForm']);

Route::get('picture/{picture}/preview', [PictureController::class, 'previewForm'])->name('picture.preview');


/*
 * конвенции роутов:
 * действие                 путь                        метод контроллера               имя роута
 * список                   GET     /items                 index                           items.index
 * форма нового             GET     /items/new             createForm                      items.new
 * сохранить                POST    /items                 create                          items.create
 * просмотр                 GET     /items/{item}          show                            items.show
 * форма                    GET     /items/{item}/edit     editForm                        items.edit
 * изменить                 PUT     /items/{item}          update                          items.update
 * удалить                  DELETE  /items/{item}          delete                          items.delete
 * какое-либо действие      POST    /items/{item}/action   action                          items.action
 *              например /pictures/{picture}/like
 * вывод связанных данных   GET     /items/{item}/entities  index (отдельный контроллер)    entities.index
 *
 * отправка PUT запросов https://stackoverflow.com/questions/28143674/laravel-form-html-with-put-method-for-put-routes
 * */


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profileForm'])->name('profile');

    Route::get('profile/edit', [AuthController::class, 'editForm'])->name('profile.edit');;
    Route::put('profile/edit', [AuthController::class, 'update'])->name('profile.update');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('picture/new', [PictureController::class, 'addForm'])->name('picture.new');
    Route::post('picture/create', [PictureController::class, 'create'])->name('picture.create');
    Route::post('picture/delete/{picture}', [PictureController::class, 'delete'])->name('picture.delete');
    Route::get('picture/{picture}/edit', [PictureController::class, 'editForm'])->name('picture.edit');
    Route::put('picture/{picture}/edit', [PictureController::class, 'update'])->name('picture.update');
    Route::get('pictures/my', [PictureController::class, 'indexMyPictures'])->name('my.pictures.index');

    Route::post('picture/{picture}/hide', [AdminController::class, 'hidePicture'])->name('picture.hide');
    Route::post('picture/{picture}/publish', [AdminController::class, 'publishPicture'])->name('picture.publish');
    Route::get('admin-panel', [AdminController::class, 'panelForm'])->name('panel.new');
    Route::post('group-action', [AdminController::class, 'groupAction'])->name('group.action');

    Route::post('picture/{picture}/like', [LikeController::class, 'likePicture'])->name('picture.like');
    Route::post('picture/{picture}/dislike', [LikeController::class, 'dislikePicture'])->name('picture.dislike');

    Route::post('review/{review}/like', [LikeController::class, 'likeReview'])->name('review.like');
    Route::post('review/{review}/dislike', [LikeController::class, 'dislikeReview'])->name('review.dislike');

    Route::get('pictures/favourites', [FavouritesController::class, 'index'])->name('favourite.pictures.index');
    Route::post('favourite-picture/{picture}/add', [FavouritesController::class, 'add'])->name('favourite.picture.add');
    Route::post('favourite-picture/{picture}/delete', [FavouritesController::class, 'delete'])->name('favourite.picture.delete');


    Route::post('review/{picture}/add', [UsersReviewsController::class, 'add'])->middleware('throttle:reviewsLimit')->name('review.add');

    Route::get('waiting-reviews/{picture}', [UsersReviewsController::class, 'indexWaitingReviews'])->name('waiting.reviews.index');
    Route::post('review/{review}/publish', [UsersReviewsController::class, 'publish'])->name('review.publish');
    Route::post('review/{review}/hide', [UsersReviewsController::class, 'hide'])->name('review.hide');
});
