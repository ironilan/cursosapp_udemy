<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //verifica si el usuario esta matriculado a un curso, las policys siempre devuelven booleano
    public function enrolled(User $user, Course $course)
    {
        return $course->students->contains($user->id);
    }

    //el signo al costado significa si el usuario esta autentificado
    public function published(?User $user, Course $course)
    {
        if ($course->status == 3) {
            return true;
        }else{
            return false;
        }
    }
}
