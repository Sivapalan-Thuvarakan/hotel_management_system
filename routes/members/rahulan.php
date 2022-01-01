<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomReservationController;


Route::get('/tests/create', [TestController::class, 'create'])->name('tests.create');
Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');
Route::post('/tests', [TestController::class, 'store'])->name('tests.store');
Route::get('/tests/{test}/edit', [TestController::class, 'edit'])->name('tests.edit');
Route::put('/tests/{test}/edit', [TestController::class, 'update'])->name('tests.update');
Route::delete('/tests/{test}', [TestController::class, 'destroy'])->name('tests.destroy');

Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create')->middleware('permission:can-add-department');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index')->middleware('permission:can-view-department');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show')->middleware('permission:can-view-department');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store')->middleware('permission:can-add-department');
Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit')->middleware('permission:can-edit-department');
Route::put('/departments/{department}/edit', [DepartmentController::class, 'update'])->name('departments.update')->middleware('permission:can-edit-department');
Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy')->middleware('permission:can-delete-department');

Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:can-add-role');
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:can-view-role');
Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:can-view-role');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:can-add-role');
Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:can-edit-role');
Route::put('/roles/{role}/edit', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:can-edit-role');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:can-delete-role');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:can-add-user');
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:can-view-user');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:can-view-user');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:can-add-user');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:can-edit-user');
Route::put('/users/{user}/edit', [UserController::class, 'update'])->name('users.update')->middleware('permission:can-edit-user');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:can-delete-user');

Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{user}/edit', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::put('prodile_details_update/{id}',  [ProfileController::class, 'updateDetails'])->name('profile.details_update');

Route::get('/room_types/create', [RoomTypeController::class, 'create'])->name('room_types.create')->middleware('permission:can-add-room_type');
Route::get('/room_types', [RoomTypeController::class, 'index'])->name('room_types.index')->middleware('permission:can-view-room_type');
Route::get('/room_types/{room_type}', [RoomTypeController::class, 'show'])->name('room_types.show')->middleware('permission:can-view-room_type');
Route::post('/room_types', [RoomTypeController::class, 'store'])->name('room_types.store')->middleware('permission:can-add-room_type');
Route::get('/room_types/{room_type}/edit', [RoomTypeController::class, 'edit'])->name('room_types.edit')->middleware('permission:can-edit-room_type');
Route::put('/room_types/{room_type}/edit', [RoomTypeController::class, 'update'])->name('room_types.update')->middleware('permission:can-edit-room_type');
Route::delete('/room_types/{room_type}', [RoomTypeController::class, 'destroy'])->name('room_types.destroy')->middleware('permission:can-delete-room_type');

Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create')->middleware('permission:can-add-room');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index')->middleware('permission:can-view-room');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show')->middleware('permission:can-view-room');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store')->middleware('permission:can-add-room');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit')->middleware('permission:can-edit-room');
Route::put('/rooms/{room}/edit', [RoomController::class, 'update'])->name('rooms.update')->middleware('permission:can-edit-room');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy')->middleware('permission:can-delete-room');

Route::get('/reservations/create', [RoomReservationController::class, 'create'])->name('reservations.create')->middleware('permission:can-add-reservations');
Route::get('/reservations', [RoomReservationController::class, 'index'])->name('reservations.index')->middleware('permission:can-view-reservations');
Route::get('/reservations/{room_reservation}', [RoomReservationController::class, 'show'])->name('reservations.show')->middleware('permission:can-view-reservations');
Route::post('/reservations', [RoomReservationController::class, 'store'])->name('reservations.store')->middleware('permission:can-add-reservations');
Route::get('/reservations/{room_reservation}/edit', [RoomReservationController::class, 'edit'])->name('reservations.edit')->middleware('permission:can-edit-reservations');
Route::put('/reservations/{room_reservation}/edit', [RoomReservationController::class, 'update'])->name('reservations.update')->middleware('permission:can-edit-reservations');
Route::delete('/reservations/{room_reservation}', [RoomReservationController::class, 'destroy'])->name('reservations.destroy')->middleware('permission:can-delete-reservations');

Route::get('/rooms-search/{id}', [RoomReservationController::class, 'roomSearch'])->name('rooms.search');
Route::post('/rooms-payment', [RoomReservationController::class, 'calculatePayment'])->name('rooms.payment');

Route::get('/customers-search', [CustomerController::class, 'customerSearch'])->name('customers.search');
Route::post('/customer-add', [CustomerController::class, 'customerAdd'])->name('customers.add');


Route::get('/reservation_report', [ReportController::class,'reservationReport'])->name('reports.reservation')->middleware('permission:can-view-reservation_report');
