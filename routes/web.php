<?php

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



/*
    routes without user authentication 
*/
Route::group( array( 'middleware' => [ 'guest' ] ), function () {
    /*
        routes for user authentication 
    */
    Route::get('/','UserController@index');
	Route::get('login','UserController@index');
	Route::post('login','UserController@processLogin')->name('login');
});

Route::group(array('middleware' => ['auth']), function () {

    Route::get('logout', 'UserController@logout')->name('logout');


	/*
        route for dashboard 
    */
    Route::get('dashboard','UserController@dashboard')->name('dashboard');

    /*
        route for updating class fees 
    */
    Route::get('edit_class', 'ClassController@editClassForm');
    Route::post('edit_class', 'ClassController@editClass');

    Route::get('search_family', 'StudentController@index');
    Route::get('search_family_autocomplete', 'StudentController@searchFamilyAutoComplete');
    Route::get('search_family_details', 'StudentController@searchFamilyDetails');

    Route::get('register/{id?}', 'StudentController@showRegisterationForm');
    Route::post('register', 'StudentController@registerStudent');

    Route::get('search_student', 'FeesManagementController@index');
    Route::get('search_student_autocomplete', 'FeesManagementController@searchStudentAutoComplete');
    Route::get('search_student_details', 'FeesManagementController@searchStudentDetails');

    Route::get('fees_entry/{id}', 'FeesManagementController@showFeesEntryForm');
    Route::post('fees_entry', 'FeesManagementController@addFees')->name('add-fees');


});