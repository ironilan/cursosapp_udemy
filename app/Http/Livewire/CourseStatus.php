<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CourseStatus extends Component
{
    use AuthorizesRequests;

	public $course, $current;


	public function mount(Course $course)
	{
		$this->course = $course;

		foreach ($course->lessons as $key => $lesson) {
			//la primera coincidencia de la leccion q no se ha completado se le asigna esa leccion a la propiedad $current
			if (!$lesson->completed) {
				$this->current = $lesson;

				//indice
				//con el metodo search buscas en la coleccion el registro q se parezca a la variable q le pasas
				//$this->index = $course->lessons->search($lesson);

				break; //para q no siga iterando
			}
		}

		if (!$this->current) {
			$this->current = $course->lessons->last();
		}

        //con esto autorizo solo a los usuarios q estan matriculados
        //primer parametro la police q quiere q verifique, y segundo el objeto q quiere q verifique
        $this->authorize('enrolled', $course);
	}

    public function render()
    {
        return view('livewire.course-status');
    }

    //metodos
    public function changeLesson(Lesson $lesson)
    {
    	$this->current = $lesson;
    }


    public function completed()
    {
    	if ($this->current->completed) {
    		//eliminar registro
    		$this->current->users()->detach(auth()->user()->id);
    	}else{
    		//agregar registro
    		$this->current->users()->attach(auth()->user()->id);
    	}

    	//para cuando marque como culminado o no culminado se actualice
    	$this->current = Lesson::find($this->current->id);
    	$this->course = Course::find($this->course->id);
    }


    //propiedades computadas
    public function getIndexProperty()
    {
    	//pluck crea una coleccion a partir de una coleccion existente
    	return $this->course->lessons->pluck('id')->search($this->current->id);
    }

    public function getPreviousProperty()
    {
    	if ($this->index == 0) {
			return null;
		}else{
			return $this->course->lessons[$this->index - 1];
		}

    }

    public function getNextProperty()
    {
    	if ($this->index == $this->course->lessons->count() - 1) {
			return null;
		}else{
			return $this->course->lessons[$this->index + 1];
		}
    }

    public function getAdvanceProperty()
    {
    	$i = 0;

    	foreach ($this->course->lessons as $key => $lesson) {
    		if ($lesson->completed) {
    			$i++;
    		}
    	}

    	$advance = ($i * 100) / $this->course->lessons->count();

    	return round($advance, 2);
    }


}
