<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
    	return view('courses.index');
    }

    public function show(Course $course)
    {
        //politica q evita q usuariso peudan entrar por la url a cursos q no estan puclicados
        $this->authorize('published', $course);

    	$similars = Course::where('category_id', $course->category_id)
    					->where('id', '<>', $course->id)
    					->where('status', 3)
    					->latest('id')
    					->take(5)
    					->get();
    	return view('courses.show', compact('course', 'similars'));
    }

    public function enrolled(Course $course)
    {
        //resuperamos la relacion students q hicimos en el modelo, con el metodo attach se guarda en la tabla pivot course_user solo debes pasarle el id del usuario. 
        $course->students()->attach(auth()->user()->id);

        return redirect()->route('courses.status', $course);
    }
}
