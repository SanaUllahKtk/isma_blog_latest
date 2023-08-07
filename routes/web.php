<?php

namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Site\DashboardController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\CommitteeMemberController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;




Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/presidents-message', [SiteController::class, 'presidentsMessage'])->name('site.p-m');
Route::get('/about-us', [SiteController::class, 'aboutUs'])->name('about-us');
Route::get('/contact-us', [SiteController::class, 'contactUs'])->name('contact-us');
Route::get('/blogs', [SiteController::class, 'blogs'])->name('blogs');
Route::get('/blog/{id}', [SiteController::class, 'blogDetails'])->name('blog-details');

Route::get('/feeds', [SiteController::class, 'feeds'])->name('feeds');
Route::get('/feed/{slug}', [SiteController::class, 'feedDetails'])->name('feed-details');
Route::get('/events', [SiteController::class, 'events'])->name('events');
Route::get('/event/{slug}', [SiteController::class, 'eventDetails'])->name('event-details');
Route::get('/event-by-date', [SiteController::class, 'eventByDate'])->name('event-by-date');
Route::get('/committee-members', [SiteController::class, 'committeeMembers'])->name('committee-members');
Route::get('/board', [SiteController::class, 'board'])->name('board');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
Route::post('/confirm-otp', [AuthController::class, 'confirmOtp'])->name('confirm-otp');












Route::post('comment', [DashboardController::class, 'comment'])->name('comment')
    ->middleware(['auth', 'active']);
Route::delete('comment', [DashboardController::class, 'deleteComment'])->name('comment')
    ->middleware(['auth', 'active']);







/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application.
|
*/





Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'checkLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'signUp']);

Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget-password');














/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application.
|
*/


Route::get('waiting-for-approval', [DashboardController::class, 'waitingForApproval'])->name('waiting-for-approval')
    ->middleware(['auth']);



Route::controller(DashboardController::class)
    ->middleware(['auth', 'active'])
    ->name('dashboard.')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', 'home')->name('home');
        //Route::get('blogs', 'blogs')->name('blogs');
        Route::get('add-feed', 'addFeed')->name('add-feed');
        Route::post('blog', 'storeBlog')->name('blog.store');
        Route::get('/blogs/{blog}/edit', 'edit')->name('blog.edit');
        Route::put('/blogs/{blog}', 'update')->name('blog.update');
        Route::get('/blogs/{blog}', 'show')->name('blog.show');
        Route::delete('blog/{id}', 'deleteBlog')->name('blog.delete');
        Route::put('blogs/status', 'blogStatus')->name('blogs.status');
        Route::get('profile', 'profile')->name('profile');

        //share blogs
        Route::get('/shared/blogs', 'sharedblogs')->name('blog.sharedblogs');
        Route::get('/favorite/blogs', 'favoriteblogs')->name('blog.favoriteblogs');

        //make blog favorite
        Route::post('/make-favorite/blog', 'makeFavoriteBlog')->name('blog.make-favorite');
        Route::post('/make-like/blog', 'makeLikeBlog')->name('blog.make-like');
        Route::post('/sharing-blog/blog', 'sharingBlog')->name('blog.sharing-blog');

      //  Route::post('blog', 'storeBlog')->name('blog.store');
      Route::get('/email/blogs', 'emailBlogs')->name('blog.emailblogs');
      Route::post('/sending-mail', 'sendingMail')->name('blog.sending-mail');

      Route::post('/seen/notification', 'removeNotification')->name('blog.remove.notification');
       
        
    });



Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web'])->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'store']);
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout-admin');
    });


Route::controller(AdminDashboardController::class)
    ->middleware('admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('blogs', 'blogs')->name('blogs');
        Route::get('all-blogs', 'allblogs')->name('allblogs');
        Route::get('add-form', 'form')->name('form');
        Route::post('store-form', 'storeform')->name('storeForm');
        Route::get('feeds', 'feeds')->name('feeds');
        Route::post('blog', 'storeBlog')->name('blog.store');
        Route::get('add-blog', 'addBlog')->name('add-blog');
        Route::put('blogs/status', 'blogStatus')->name('blogs.status');
        Route::delete('blog/{id}', 'deleteBlog')->name('blog.delete');

        Route::get('add-event', 'addEvent')->name('add-event');
        Route::post('add-event', 'storeEvent');
        Route::get('events', 'events')->name('events');
        Route::delete('event/{id}', 'deleteEvents')->name('event.delete');




        Route::controller(SliderController::class)
            ->prefix('slider')
            ->name('slider.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('store', 'store')->name('store');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        Route::controller(MemberController::class)
            ->prefix('member')
            ->name('member.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('store', 'store')->name('store');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        Route::controller(CommitteeMemberController::class)
            ->prefix('committee-member')
            ->name('committee-member.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('store', 'store')->name('store');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });




        Route::prefix('users')
            ->name('users.')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('status', 'status')->name('status');
            });
    });
