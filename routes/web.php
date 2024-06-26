<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\EpimageController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\RankingContoller;
use App\Http\Controllers\CashController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WorksController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\RankingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// 新しい投稿
Route::get('post/new_post', [PostController::class, 'new_post'])->name('post.new_post');

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
});

Route::middleware(['verified'])->group(function () {
    // My page
    Route::get('mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('mypage/account', [ProfileController::class, 'show'])->name('profile.show');
    Route::delete('mypage/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('mypage/cash', [CashController::class, 'index'])->name('cash.index');
    // bookshelf
    Route::get('bookshelf/top', [BookshelfController::class, 'top'])->name('bookshelf.top');
    Route::get('bookshelf/favorite', [BookshelfController::class, 'favorite'])->name('bookshelf.favorite');
    Route::get('bookshelf/history', [BookshelfController::class, 'history'])->name('bookshelf.history');
    // workspace
    Route::get('workspace', [WorksController::class, 'workspace'])->name('workspace');
    Route::get('my_manga', [WorksController::class, 'mymanga'])->name('mymanga');
    // post resource
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    // episode 
    Route::get('post/{post}/chapter/edit', [EpisodeController::class, 'index_edit'])->name('episode.index_edit');
    Route::get('post/{post}/chapter_id/{episode}/edit', [EpisodeController::class, 'edit'])->name('episode.edit');
    Route::patch('/post/{post}/{episode}', [EpisodeController::class, 'update'])->name('episode.update');
    Route::delete('/chapter/{episode}', [EpisodeController::class, 'destroy'])->name('episode.destroy');
    // episode create
    Route::get('/post/{post}/chapter/create', [EpisodeController::class, 'create'])->name('episode.create');
    Route::post('/post/{post}/chapter/store', [EpisodeController::class, 'store'])->name('episode.store');
    // commnent
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('post/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

// post
Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

// eposode表示
Route::get('/post/{post}/chapter/{number}', [EpisodeController::class, 'show'])->name('episode.show');
Route::get('/post/{post}/navigate/{number}', [EpisodeController::class, 'navigate'])->name('episode.navigate');
Route::get('/post/{post}/chapter', [EpisodeController::class, 'index'])->name('episode.index');

// 検索
Route::get('/search', [SearchController::class, 'search'])->name('search');

// ランキング
Route::get('ranking/daily', [RankingContoller::class, 'ranking_daily'])->name('ranking.daily');
Route::get('ranking/weekly', [RankingContoller::class, 'ranking_weekly'])->name('ranking.weekly');
Route::get('ranking/monthly', [RankingContoller::class, 'ranking_monthly'])->name('ranking.monthly');
Route::get('ranking/all', [RankingContoller::class, 'ranking_all'])->name('ranking.all');

// filter
Route::get('/filter', [FilterController::class, 'filter'])->name('filter');
Route::get('/filter/result', [FilterController::class, 'filter_result'])->name('filter.result');
Route::get('/filter/other', [FilterController::class, 'filter_other'])->name('filter.other');

// 作者表示
Route::get('/user/{user}', [AuthorController::class, 'index'])->name('auther.index');

// いいね
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'unlike'])->name('posts.unlike');

// コメント
Route::get('/post/{post}/comment', [CommentController::class, 'show'])->name('comment.show');

// Contact
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

// footer
Route::get('report', [FooterController::class, 'report_create'])->name('report_create');
Route::post('report/issue', [FooterController::class, 'report_store'])->name('report.store');
Route::get('terms', [FooterController::class, 'terms'])->name('terms');
Route::get('privacy', [FooterController::class, 'privacy'])->name('privacy');
Route::get('copyright', [FooterController::class, 'copyright'])->name('copyright');
Route::get('cookie', [FooterController::class, 'cookie'])->name('cookie');
Route::get('content', [FooterController::class, 'content'])->name('content');
Route::get('community', [FooterController::class, 'community'])->name('community');
Route::get('claim', [FooterController::class, 'claim'])->name('claim');
// Route::get('advertising', [FooterController::class, 'advertising'])->name('advertising');


require __DIR__ . '/auth.php';
