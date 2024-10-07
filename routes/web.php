<?php

use App\Http\Controllers\Backend\EventsController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserApprovalController;
use App\Http\Controllers\Backend\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\frontend\EventsControllerFrontent;
use App\Http\Controllers\Backend\NotificationController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/banner', function () {


    return view('backend.pages.banner.index');
});





Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update the profile
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::post('/store_default_post', [PostController::class, 'storeDefault'])->name('store_default_post');
    Route::patch('/post/{post}/update_status', [PostController::class, 'updateStatus'])->name('post.update_status');
});







// frontend form builder 



// End Form Builder===============================================================




// frontent   event

Route::get('events', [EventsControllerFrontent::class, 'viewAll'])->name('events.viewAll');
Route::get('events/previous', [EventsControllerFrontent::class, 'previousEvents'])->name('events.previous');
Route::get('events/upcoming', [EventsControllerFrontent::class, 'upcomingEvents'])->name('events.upcoming');





Route::get('/volunteer/register', [VolunteerController::class, 'showRegisterForm'])->name('volunteer.register');
Route::post('/volunteer/register', [VolunteerController::class, 'register']);



























Route::group(['prefix' => 'admin'], function () {


    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');


    // Login Routes     // Logout Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');



    //  role and permission route 
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);


    // admin route 
    Route::resource('admins', 'Backend\AdminsController');
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    Route::post('admins/assignRole', 'Backend\AdminsController@assignRole')->name('admin.admins.assignRole');
    Route::get('getUsersByType', 'Backend\AdminsController@getUsersByType')->name('admin.getUsersByType');


    // user route 
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::get('userlistjson', 'Backend\UsersController@userlist')->name('admin.users.userlistjson');

    Route::get('/users/new/approval', [UserApprovalController::class, 'index'])->name('admin.users.approvallist');
    Route::post('/users/new/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.users.approve');

    Route::get('users/bulk-import', 'Backend\UsersController@importView')->name('admin.users.import.view');
    Route::get('/users/export', 'Backend\UsersController@export')->name('admin.users.export');
    Route::post('users/bulk-import', 'Backend\UsersController@import')->name('admin.users.import');
    Route::post('users/import-excel', 'Backend\UsersController@importExcel')->name('admin.users.import.excel');


    // Route::get('users/{id}/edit', 'Backend\UsersController@edit')->name('admin.users.edit'); // For getting user data
    // Route::post('users/{id}/update', 'Backend\UsersController@ajaxUpdate')->name('admin.users.ajaxUpdate');
    // Route::delete('users/{id}', 'Backend\UsersController@ajaxDestroy')->name('admin.users.ajaxDestroy');







    // Volunteer Management Routes
    Route::get('/pendingvolunteers', 'Backend\VolunteerController@showPendingVolunteers')->name('admin.volunteers');
    Route::get('/volunteers', 'Backend\VolunteerController@showVolunteersView')->name('admin.pendingvolunteers');
    Route::post('/volunteers/approve/{id}', 'Backend\VolunteerController@approveVolunteer')->name('admin.volunteers.approve');
    Route::patch('/volunteers/status/{id}', 'Backend\VolunteerController@updateVolunteerStatus')->name('admin.volunteers.update_status');




    // events 
    // Display a listing of the resource.
    Route::get('events', [EventsController::class, 'index'])->name('events.index');

    // Route to refetch events
    Route::get('events-refetch', [EventsController::class, 'refetchEvents'])->name('events.refetch');

    // Store new event
    Route::post('events', [EventsController::class, 'store'])->name('events.store');

    // Display the specified event
    Route::get('events/{event}', [EventsController::class, 'show'])->name('events.show');

    // Show the form for editing the specified event
    Route::get('events/{event}/edit', [EventsController::class, 'edit'])->name('events.edit');

    // Update the specified event
    Route::put('events/{event}', [EventsController::class, 'update'])->name('events.update');

    // Remove the specified event
    Route::delete('events/{event}', [EventsController::class, 'destroy'])->name('events.destroy');
    Route::get('events-list', [EventsController::class, 'list'])->name('events.list');
    Route::post('events/{event}/countdown', [EventsController::class, 'updateCountdown'])->name('events.updateCountdown');
    Route::get('events/{event}/edit-details', [EventsController::class, 'editDetails'])->name('events.editDetails');
    Route::get('events/{event}/details', [EventsController::class, 'showDetails'])->name('events.showDetails');




    //   form builder 

    // Display the form builder index (list of all forms)
    Route::get('form-builder', [FormBuilderController::class, 'index'])->name('formbuilder.index');

    // Route to create a new form
    Route::view('formbuilder', 'backend.pages.FormBuilder.create')->name('formbuilder.create');

    // Route to save a new form
    Route::post('save-form-builder', [FormBuilderController::class, 'create'])->name('formbuilder.store');

    // Route to delete a form
    Route::delete('form-delete/{id}', [FormBuilderController::class, 'destroy'])->name('formbuilder.delete');

    // Route to show the edit form page
    Route::view('edit-form-builder/{id}', 'backend.pages.FormBuilder.edit')->name('formbuilder.edit');

    // Route to get the form data for editing (API call or fetch data)
    Route::get('get-form-builder-edit', [FormBuilderController::class, 'editData'])->name('formbuilder.editData');

    // Route to update an existing form
    Route::post('update-form-builder', [FormBuilderController::class, 'update'])->name('formbuilder.update');

    // Route to view a specific form
    Route::view('read-form-builder/{id}', 'backend.pages.FormBuilder.read')->name('formbuilder.read');




    //   setting 

    // Volunteer Settings route
    Route::get('/settings/volunteer', [SettingController::class, 'volunteer'])->name('admin.settings.volunteer');
    Route::post('/admin/volunteer-status', [SettingController::class, 'toggleVolunteerStatus'])->name('admin.toggleVolunteerStatus');

    // Frontend CMS Settings route
    Route::get('/settings/frontend', [SettingController::class, 'frontend'])->name('admin.settings.frontend');


    //  notification 
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::get('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');






    // Route::group(['prefix' => 'templates'], function () {
    //     Route::get('/', 'CertificateController@CertificatesTemplatesList');
    //     Route::get('/new', 'CertificateController@CertificatesNewTemplate');
    //     Route::post('/store', 'CertificateController@CertificatesTemplateStore');
    //     Route::post('/preview', 'CertificateController@CertificatesTemplatePreview');
    //     Route::get('/{template_id}/edit', 'CertificateController@CertificatesTemplatesEdit');
    //     Route::post('/{template_id}/update', 'CertificateController@CertificatesTemplateStore');
    //     Route::get('/{template_id}/delete', 'CertificateController@CertificatesTemplatesDelete');
    // });
});

require __DIR__ . '/auth.php';
