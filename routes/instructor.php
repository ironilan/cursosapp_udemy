<?php

use App\Http\Controllers\instructor\CourseController;
use App\Http\Livewire\Instructor\CourseCurriculum;
use Illuminate\Support\Facades\Route;

//de esta manera cuando pongan solo /instructor lo redirige a instructor/courses
Route::redirect('', 'instructor/courses');

//recuerda q los nombres de ruta empiezan con " instructor. " asi lo definimos en RouteServiceProvider
//Route::get('courses', InstructorCourse::class)->middleware('can:Leer cursos')->name('courses.index');


Route::resource('courses', CourseController::class)->names('courses');

Route::get('courses/{course}/curriculum', CourseCurriculum::class)->name('courses.curriculum');
