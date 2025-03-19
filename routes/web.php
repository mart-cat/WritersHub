<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;

// === Гостевые маршруты (без авторизации) ===
Route::get('/', [HomeController::class, 'index'])->name('home.index'); // Главная страница
Route::get('/about', [HomeController::class, 'about'])->name('home.about'); // О проекте
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact'); // Контакты
Route::get('/texts', [TextController::class, 'index'])->name('texts.index'); // Список всех текстов
Route::get('/texts/{id}', [TextController::class, 'show'])->name('texts.show'); // Просмотр конкретного текста

// === Маршруты для авторизации ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/ajax', [AuthController::class, 'login'])->name('login.ajax');
Route::post('/verify-2fa', [AuthController::class, 'verifyTwoFactorAjax'])->name('2fa.verify.ajax');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === Маршруты для зарегистрированных пользователей ===
Route::middleware('auth')->group(function () {
    // Личный кабинет
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard'); // Главная в личном кабинете
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('user.favorites'); // Избранное
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('user.subscriptions'); // Подписки
    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('user.profile'); // Профиль пользователя
    Route::post('/profile/{id}/update', [UserController::class, 'update'])->name('user.profile.update'); // Редактирование профиля

    // Управление текстами
    Route::post('/text/save', [TextController::class, 'store'])->name('texts.store'); // Сохранение текста
    Route::get('/text/create', [TextController::class, 'create'])->name('texts.create'); // Создание текста
    Route::post('/parse-file', [TextController::class, 'parseFile'])->name('texts.parseFile'); // Парсинг текста
    Route::get('/text/{id}/edit', [TextController::class, 'edit'])->name('texts.edit'); // Редактирование текста
    Route::put('/text/{id}', [TextController::class, 'update'])->name('texts.update'); // Обновление текста
    Route::delete('/text/{id}', [TextController::class, 'destroy'])->name('texts.destroy'); // Удаление текста

    // Комментарии
    Route::post('/text/{id}/comments', [CommentController::class, 'store'])->name('comments.store'); // Добавление комментария
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy'); // Удаление комментария

    // Избранное
    Route::post('/text/{id}/favorite', [FavoriteController::class, 'store'])->name('favorites.store'); // Добавить в избранное
    Route::delete('/text/{id}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy'); // Убрать из избранного
    Route::delete('/text/{id}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle'); // Переключатель избранное

    // Подписки
    Route::post('/authors/{id}/subscribe', [SubscriptionController::class, 'store'])->name('subscriptions.store'); // Подписаться на автора
    Route::delete('/authors/{id}/unsubscribe', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy'); // Отписаться от автора

    // Рейтинг
    Route::post('/authors/{id}/ratings', [SubscriptionController::class, 'store'])->name('ratings.store'); // Подписаться на автора
    Route::delete('/authors/{id}/unratings', [SubscriptionController::class, 'destroy'])->name('ratings.destroy'); // Отписаться от автора
});

// === Маршруты Временно убраны мидлвар ==

//Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Управление пользователями
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Управление категориями
    Route::get('/categories', [AdminController::class, 'manageCategories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    // Управление жанрами
    Route::get('/genres', [AdminController::class, 'manageGenres'])->name('admin.genres');
    Route::post('/genres', [AdminController::class, 'storeGenre'])->name('admin.genres.store');
    Route::delete('/genres/{id}', [AdminController::class, 'deleteGenre'])->name('admin.genres.delete');
//});
