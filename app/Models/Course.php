<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    //bloquea campos q no pueden ser mnodificados por asignacion masiva (propiedad create())
    protected $guarded = ['id', 'status'];

    //con esta propiedad podemos contar cuantos alumnos tiene ese curso por la relacion logica q pusimos en abajo con el mismo nombre "students"
    protected $withCount = ['students', 'reviews'];

    //estas son cosntantes para acceder a los valores en la migracion
    const BORRADOR = 1;
    const REVISION = 2;
    const PUBLICADO = 3;

    //con este atributo nos devuelve la coleccion de reviews garcias a la relacion q hicimos abajo
    //$this->reviews
    public function getRatingAttribute()
    {

        if ($this->reviews_count) {
            //el avg es para q nos de el promedio de rating
            //el round es para redondear
            return round($this->reviews->avg('rating'), 1);
        }else{
            return 5;
        }
        
    }

    //query scopes
    public function scopeCategory($query, $category_id)
    {
        if ($category_id) {
            return $query->where('category_id', $category_id);
        }
    }

    public function scopeLevel($query, $level_id)
    {
        if ($level_id) {
            return $query->where('level_id', $level_id);
        }
    }


    public function getRouteKeyName()
    {
        return "slug";
    }


    //relacion uno a muchos
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function requirements()
    {
        return $this->hasMany('App\Models\Requirement');
    }

    public function goals()
    {
        return $this->hasMany('App\Models\Goal');
    }

    public function audiences()
    {
        return $this->hasMany('App\Models\Audience');
    }

    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }



    //relacion uno a muchos inversa
    public function teacher()
    {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }

    

    public function level()
    {
        return $this->belongsTo('App\Models\Level');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function price()
    {
        return $this->belongsTo('App\Models\Price');
    }


    //relacion muchos a muchos
    public function students()
    {
    	return $this->belongsToMany('App\Models\User');
    }

    //relacion uno a uno polimorfica
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }


    //ir a lecciones desde cursos a traves de sections
    public function lessons()
    {
        //recibe dos parametros
        //1- modelo de tabla final
        //2- el modelo de la tabla intermedia
        return $this->hasManyThrough('App\Models\Lesson', 'App\Models\Section');
    }
}
