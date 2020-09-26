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

#---------------
#|    Home     |
#---------------
Route::get('/', 'pagesController@home')->name('home');
Route::get('/home', 'pagesController@home')->name('home');

#---------------
#|  1Account   |
#---------------
Route::resource('/viewAccountDetail', 'UserController');
Route::resource('/parentAccountlist', 'AccountlistController');
Route::resource('/studentAccountlist', 'AccountlistController');
Route::resource('/teacherAccountlist', 'AccountlistController');
Route::resource('/acceptParentAccount', 'AcceptlistController');
Route::resource('/acceptStudentAccount', 'AcceptlistController');
Route::resource('/acceptTeacherAccount', 'AcceptlistController');
Route::resource('/accountAccessCode', 'AccesscodeController');
Route::resource('/sectionCatalog', 'SectionController');

#---------------
#|   2class    |
#---------------
Route::resource('/subjectCatalog', 'SubjectController');
Route::get('/classCatalog/{subject_id}', 'ClassCatalogController@index');
Route::post('/classCatalog', 'ClassCatalogController@store');
Route::put('/classCatalog/{class_id}', 'ClassCatalogController@update');
Route::delete('/classCatalog/{class_id}', 'ClassCatalogController@destroy');
Route::resource('/enrollment', 'EnrollmentController');
Route::resource('/onGoingClasses', 'OnGoingClassesController');
Route::resource('/completedClass', 'CompletedClassesController');

Route::get('/viewClass/{class_id}', 'pagesController@viewClass');
Route::resource('/viewClass/{class_id}/detail', 'LessonsController');

Route::resource('/viewClass/{class_id}/task', 'TasksController');
Route::resource('/viewClass/{class_id}/task/{quiz_id}/takeQuiz', 'TakeQuizController');
Route::resource('/viewClass/{class_id}/task/{quiz_id}/quizScoring', 'ScoreQuizController');
Route::resource('/viewClass/{class_id}/task/{task_id}/taskScoring', 'ScoreTaskController');

Route::resource('/viewClass/{class_id}/resources', 'ClassResourcesController');

Route::resource('/viewClass/{class_id}/attendance', 'AttendanceController');
Route::resource('/viewClass/{class_id}/grade', 'GradeController');


#---------------
#| 3Resources  |
#---------------
Route::resource('/onlineQuizsStorage','QuizStorageController');
Route::resource('/onlineQuizsStorage/{quiz_id}/item','GenerateQuizzesController');
Route::resource('/resource','ResourcesController');


Auth::routes();
Route::get('access', 'Auth\RegisterController@access');
Route::post('access', 'Auth\RegisterController@checkCode');
