<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// PUBLIC WEBSITE
// ════════════════════════════════════════════════════════════
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/services',  [HomeController::class, 'services'])->name('services');
Route::get('/about',     [HomeController::class, 'about'])->name('about');
Route::get('/contact',   [HomeController::class, 'contact'])->name('contact');

// Public booking (guests)
Route::prefix('book')->name('book.')->group(function () {
    Route::get('/',           [\App\Http\Controllers\Public\BookingController::class, 'index'])->name('index');
    Route::get('/slots',      [\App\Http\Controllers\Public\BookingController::class, 'slots'])->name('slots');
    Route::get('/available-days',[\App\Http\Controllers\Public\BookingController::class, 'availableDays'])->name('available-days');
    Route::post('/',          [\App\Http\Controllers\Public\BookingController::class, 'store'])->name('store');
    Route::get('/confirm/{appointment}', [\App\Http\Controllers\Public\BookingController::class, 'confirm'])->name('confirm');
});

// ════════════════════════════════════════════════════════════
// AUTHENTICATION
// ════════════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);

    // Password reset
    Route::get('/forgot-password',         [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password',        [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}',  [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',         [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ════════════════════════════════════════════════════════════
// ADMIN PANEL
// ════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users',        \App\Http\Controllers\Admin\UserController::class)
        ->names(['index' => 'users', 'create' => 'users.create', 'store' => 'users.store',
                 'show' => 'users.show', 'edit' => 'users.edit', 'update' => 'users.update', 'destroy' => 'users.destroy']);
    // Services
    Route::resource('services',     \App\Http\Controllers\Admin\ServiceController::class)
        ->names(['index' => 'services', 'create' => 'services.create', 'store' => 'services.store',
                 'show' => 'services.show', 'edit' => 'services.edit', 'update' => 'services.update', 'destroy' => 'services.destroy']);
    // Patients
    Route::resource('patients',     \App\Http\Controllers\Admin\PatientController::class)
        ->names(['index' => 'patients', 'create' => 'patients.create', 'store' => 'patients.store',
                 'show' => 'patients.show', 'edit' => 'patients.edit', 'update' => 'patients.update', 'destroy' => 'patients.destroy']);
    // Appointments
    Route::get('/appointments',               [\App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('appointments');
    Route::post('/appointments',              [\App\Http\Controllers\Admin\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Admin\AppointmentController::class, 'show'])->name('appointments.show');
    // Billing
    Route::get('/billing',              [\App\Http\Controllers\Admin\BillingController::class, 'index'])->name('billing');
    Route::get('/billing/{invoice}',    [\App\Http\Controllers\Admin\BillingController::class, 'show'])->name('billing.show');
    Route::get('/billing/{invoice}/pdf',[\App\Http\Controllers\Admin\BillingController::class, 'pdf'])->name('billing.pdf');
    // Inventory
    Route::get('/inventory',     [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory');
    // Reports
    Route::get('/reports',                    [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/revenue',            [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/export/revenue',     [\App\Http\Controllers\Admin\ReportController::class, 'exportRevenue'])->name('reports.export.revenue');
    Route::get('/reports/export/appointments',[\App\Http\Controllers\Admin\ReportController::class, 'exportAppointments'])->name('reports.export.appointments');
    Route::get('/reports/export/patients',    [\App\Http\Controllers\Admin\ReportController::class, 'exportPatients'])->name('reports.export.patients');
    Route::get('/reports/export/inventory',   [\App\Http\Controllers\Admin\ReportController::class, 'exportInventory'])->name('reports.export.inventory');
    // Settings
    Route::get('/settings',      [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings',     [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});

// ════════════════════════════════════════════════════════════
// STAFF PANEL
// ════════════════════════════════════════════════════════════
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('/appointments',             [\App\Http\Controllers\Staff\AppointmentController::class, 'index'])->name('appointments');
    Route::post('/appointments',            [\App\Http\Controllers\Staff\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}',[\App\Http\Controllers\Staff\AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/approve',    [\App\Http\Controllers\Staff\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('/appointments/{appointment}/cancel',     [\App\Http\Controllers\Staff\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::patch('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Staff\AppointmentController::class, 'reschedule'])->name('appointments.reschedule');

    // Patients
    Route::resource('patients', \App\Http\Controllers\Staff\PatientController::class)
        ->names(['index' => 'patients', 'create' => 'patients.create', 'store' => 'patients.store',
                 'show' => 'patients.show', 'edit' => 'patients.edit', 'update' => 'patients.update', 'destroy' => 'patients.destroy']);

    // Billing
    Route::get('/billing',                      [\App\Http\Controllers\Staff\BillingController::class, 'index'])->name('billing');
    Route::get('/billing/create/{appointment}', [\App\Http\Controllers\Staff\BillingController::class, 'create'])->name('billing.create');
    Route::post('/billing',                     [\App\Http\Controllers\Staff\BillingController::class, 'store'])->name('billing.store');
    Route::get('/billing/{invoice}',            [\App\Http\Controllers\Staff\BillingController::class, 'show'])->name('billing.show');
    Route::post('/billing/{invoice}/payment',   [\App\Http\Controllers\Staff\BillingController::class, 'recordPayment'])->name('billing.payment');
    Route::get('/billing/{invoice}/print',      [\App\Http\Controllers\Staff\BillingController::class, 'print'])->name('billing.print');
    Route::get('/billing/{invoice}/pdf',        [\App\Http\Controllers\Staff\BillingController::class, 'pdf'])->name('billing.pdf');

    // Inventory
    Route::get('/inventory',                          [\App\Http\Controllers\Staff\InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/items/{item}/movements',   [\App\Http\Controllers\Staff\InventoryController::class, 'movements'])->name('inventory.movements');
    Route::post('/inventory/items/{item}/adjust',     [\App\Http\Controllers\Staff\InventoryController::class, 'adjustStock'])->name('inventory.adjust');
    Route::resource('inventory/items', \App\Http\Controllers\Staff\InventoryItemController::class)
        ->names(['index' => 'inventory.items', 'create' => 'inventory.items.create', 'store' => 'inventory.items.store',
                 'show' => 'inventory.items.show', 'edit' => 'inventory.items.edit', 'update' => 'inventory.items.update', 'destroy' => 'inventory.items.destroy']);
});

// ════════════════════════════════════════════════════════════
// DOCTOR PANEL
// ════════════════════════════════════════════════════════════
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DoctorDashboard::class, 'index'])->name('dashboard');

    // Schedule
    Route::get('/appointments',                       [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/{appointment}',         [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/start', [\App\Http\Controllers\Doctor\AppointmentController::class, 'start'])->name('appointments.start');
    Route::patch('/appointments/{appointment}/complete',[\App\Http\Controllers\Doctor\AppointmentController::class, 'complete'])->name('appointments.complete');

    // Clinical notes
    Route::get('/appointments/{appointment}/notes',  [\App\Http\Controllers\Doctor\ClinicalNoteController::class, 'create'])->name('appointments.notes');
    Route::post('/appointments/{appointment}/notes', [\App\Http\Controllers\Doctor\ClinicalNoteController::class, 'store'])->name('appointments.notes.store');

    // Patients (read-only for own patients)
    Route::get('/patients',        [\App\Http\Controllers\Doctor\PatientController::class, 'index'])->name('patients');
    Route::get('/patients/{patient}', [\App\Http\Controllers\Doctor\PatientController::class, 'show'])->name('patients.show');
    // Doctor Schedule
    Route::get('/schedule',  [\App\Http\Controllers\Doctor\ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [\App\Http\Controllers\Doctor\ScheduleController::class, 'update'])->name('schedule.update');

});

// ════════════════════════════════════════════════════════════
// PATIENT PORTAL
// ════════════════════════════════════════════════════════════
Route::prefix('portal')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard',    [PatientDashboard::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'index'])->name('appointments');
    Route::delete('/appointments/{appointment}', [\App\Http\Controllers\Patient\AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Invoices
    Route::get('/invoices',         [\App\Http\Controllers\Patient\InvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Patient\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/pdf', [\App\Http\Controllers\Patient\InvoiceController::class, 'pdf'])->name('invoices.pdf');

    // Profile
    Route::get('/profile',      [\App\Http\Controllers\Patient\ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile',      [\App\Http\Controllers\Patient\ProfileController::class, 'update'])->name('profile.update');
});

// ════════════════════════════════════════════════════════════
// NOTIFICATIONS
// ════════════════════════════════════════════════════════════
Route::middleware('auth')->group(function () {
    Route::post('/notifications/{id}/read', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    })->name('notifications.read');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return back();
    })->name('notifications.read-all');
});
