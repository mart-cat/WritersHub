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
Route::post('/login', [AuthController::class, 'login']);
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
    Route::get('/texts/create', [TextController::class, 'create'])->name('texts.create'); // Создание текста
    Route::post('/texts', [TextController::class, 'store'])->name('texts.store'); // Сохранение текста
    Route::get('/texts/{id}/edit', [TextController::class, 'edit'])->name('texts.edit'); // Редактирование текста
    Route::put('/texts/{id}', [TextController::class, 'update'])->name('texts.update'); // Обновление текста
    Route::delete('/texts/{id}', [TextController::class, 'destroy'])->name('texts.destroy'); // Удаление текста

    // Комментарии
    Route::post('/texts/{id}/comments', [CommentController::class, 'store'])->name('comments.store'); // Добавление комментария
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy'); // Удаление комментария

    // Избранное
    Route::post('/texts/{id}/favorite', [FavoriteController::class, 'store'])->name('favorites.store'); // Добавить в избранное
    Route::delete('/texts/{id}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy'); // Убрать из избранного
    Route::delete('/texts/{id}/toggle', [FavoriteController::class, 'destroy'])->name('favorites.toggle');

    // Подписки
    Route::post('/authors/{id}/subscribe', [SubscriptionController::class, 'store'])->name('subscriptions.store'); // Подписаться на автора
    Route::delete('/authors/{id}/unsubscribe', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy'); // Отписаться от автора

    // Рейтинг
    Route::post('/authors/{id}/ratings', [SubscriptionController::class, 'store'])->name('ratings.store'); // Подписаться на автора
    Route::delete('/authors/{id}/unratings', [SubscriptionController::class, 'destroy'])->name('ratings.destroy'); // Отписаться от автора
});

// === Маршруты для администраторов ===
Route::middleware(['auth', 'admin'])->group(function () {
    // Админ панель
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // Главная страница админки
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users'); // Управление пользователями
    Route::get('/admin/texts', [AdminController::class, 'manageTexts'])->name('admin.texts'); // Управление текстами

    // Удаление и модерация
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Удаление пользователя
    Route::put('/admin/texts/{id}/moderate', [AdminController::class, 'moderateText'])->name('admin.texts.moderate'); // Модерация текста
});
