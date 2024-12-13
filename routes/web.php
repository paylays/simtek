<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineDeviceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ViewExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('auth.login');
});
 
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('', 'index')->name('dashboard');
    });
    
    Route::controller(PatientController::class)->prefix('patients')->group(function () {
        Route::get('', 'index')->name('patients');
        Route::get('create', 'create')->name('patients.create');
        Route::post('store', 'store')->name('patients.store');
        Route::get('show/{id}', 'show')->name('patients.show');
        Route::get('edit/{id}', 'edit')->name('patients.edit');
        Route::put('edit/{id}', 'update')->name('patients.update');
        Route::delete('destroy/{id}', 'destroy')->name('patients.destroy');
    });
    
    Route::controller(DoctorController::class)->prefix('doctors')->group(function () {
        Route::get('', 'index')->name('doctors');
        Route::get('create', 'create')->name('doctors.create');
        Route::post('store', 'store')->name('doctors.store');
        Route::get('show/{id}', 'show')->name('doctors.show');
        Route::get('edit/{id}', 'edit')->name('doctors.edit');
        Route::put('edit/{id}', 'update')->name('doctors.update');
        Route::delete('destroy/{id}', 'destroy')->name('doctors.destroy');
    });
    
    Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
        Route::get('', 'index')->name('employees');
        Route::get('create', 'create')->name('employees.create');
        Route::post('store', 'store')->name('employees.store');
        Route::get('show/{id}', 'show')->name('employees.show');
        Route::get('edit/{id}', 'edit')->name('employees.edit');
        Route::put('edit/{id}', 'update')->name('employees.update');
        Route::delete('destroy/{id}', 'destroy')->name('employees.destroy');
    });
    
    Route::controller(UnitController::class)->prefix('units')->group(function () {
        Route::get('', 'index')->name('units');
        Route::get('create', 'create')->name('units.create');
        Route::post('store', 'store')->name('units.store');
        Route::get('show/{id}', 'show')->name('units.show');
        Route::get('edit/{id}', 'edit')->name('units.edit');
        Route::put('edit/{id}', 'update')->name('units.update');
        Route::delete('destroy/{id}', 'destroy')->name('units.destroy');
    });
    
    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('', 'index')->name('categories');
        Route::get('create', 'create')->name('categories.create');
        Route::post('store', 'store')->name('categories.store');
        Route::get('show/{id}', 'show')->name('categories.show');
        Route::get('edit/{id}', 'edit')->name('categories.edit');
        Route::put('edit/{id}', 'update')->name('categories.update');
        Route::delete('destroy/{id}', 'destroy')->name('categories.destroy');
    });
    
    Route::controller(SupplierController::class)->prefix('suppliers')->group(function () {
        Route::get('', 'index')->name('suppliers');
        Route::get('create', 'create')->name('suppliers.create');
        Route::post('store', 'store')->name('suppliers.store');
        Route::get('show/{id}', 'show')->name('suppliers.show');
        Route::get('edit/{id}', 'edit')->name('suppliers.edit');
        Route::put('edit/{id}', 'update')->name('suppliers.update');
        Route::delete('destroy/{id}', 'destroy')->name('suppliers.destroy');
    });
    
    Route::controller(MedicineController::class)->prefix('medicines')->group(function () {
        Route::get('', 'index')->name('medicines');
        Route::get('create', 'create')->name('medicines.create');
        Route::post('store', 'store')->name('medicines.store');
        Route::get('show/{id}', 'show')->name('medicines.show');
        Route::get('edit/{id}', 'edit')->name('medicines.edit');
        Route::put('edit/{id}', 'update')->name('medicines.update');
        Route::delete('destroy/{id}', 'destroy')->name('medicines.destroy');
    });
    
    Route::controller(MedicineDeviceController::class)->prefix('medicinedevices')->group(function () {
        Route::get('', 'index')->name('medicinedevices');
        Route::get('create', 'create')->name('medicinedevices.create');
        Route::post('store', 'store')->name('medicinedevices.store');
        Route::get('show/{id}', 'show')->name('medicinedevices.show');
        Route::get('edit/{id}', 'edit')->name('medicinedevices.edit');
        Route::put('edit/{id}', 'update')->name('medicinedevices.update');
        Route::delete('destroy/{id}', 'destroy')->name('medicinedevices.destroy');
    });
    
    Route::controller(TransactionController::class)->prefix('transactions')->group(function () {
        Route::get('', 'index')->name('transactions');
        Route::get('create', 'create')->name('transactions.create');
        Route::post('store', 'store')->name('transactions.store');
        Route::get('show/{id}', 'show')->name('transactions.show');
        Route::get('edit/{id}', 'edit')->name('transactions.edit');
        Route::put('edit/{id}', 'update')->name('transactions.update');
        Route::delete('destroy/{id}', 'destroy')->name('transactions.destroy');
    });
    
    Route::controller(ViewExportController::class)->prefix('viewexports')->group(function () {
        Route::get('/obat', 'indexMedicine')->name('viewexports');
        Route::get('/obat/view/pdf', 'viewPdfMedicine')->name('viewexportsmedicine.view');
        Route::get('/obat/download/pdf', 'downloadPdfMedicine')->name('viewexportsmedicine.download');
    
        Route::get('/alat_kesehatan', 'indexMedicineDevice')->name('viewexports');
        Route::get('/alat_kesehatan/view/pdf', 'viewPdfMedicineDevice')->name('viewexportsmedicinedevice.view');
        Route::get('/alat_kesehatan/download/pdf', 'downloadPdfMedicineDevice')->name('viewexportsmedicinedevice.download');
    
        Route::get('/transaksi', 'indexTransaction')->name('viewexports');
        Route::get('/transaksi/view/pdf', 'viewPdfTransaction')->name('viewexportstransaction.view');
        Route::get('/transaksi/download/pdf', 'downloadPdfTransaction')->name('viewexportstransaction.download');
    });
    
    Route::controller(ReportController::class)->prefix('reports')->group(function () {
        Route::get('/obat', 'indexMedicine')->name('reportsmedicine');
        Route::get('/alatkesehatan', 'indexMedicineDevice')->name('reportsmedicinedevice');
        Route::get('/transaksi', 'indexTransaction')->name('reportstransaction');
    });

    Route::controller(AuthController::class)->prefix('profiles')->group(function () {
        Route::get('', 'index')->name('profiles.index');
        Route::get('edit', 'edit')->name('profiles.edit');
        Route::put('update', 'updateProfile')->name('profiles.update');
        Route::put('update', 'updateProfile')->name('profiles.update');
        Route::put('updatepassword', 'updatePassword')->name('profiles.update.password');
    });

});

