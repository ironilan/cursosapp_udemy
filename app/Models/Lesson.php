<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    //bloquea campos q no pueden ser mnodificados por asignacion masiva (propiedad create())
    protected $guarded = ['id'];


    //definicmos un nuevo atribute
    public function getCompletedAttribute()
    {
        //trae todos los usuarios q han marcado como culminada la leccion
        return $this->users->contains(auth()->user()->id);
    }

    //relacion de uno a uno
    public function description()
    {
    	return $this->hasOne('App\Models\Description');
    }

    //relacion uno a muchos inversa
    public function section()
    {
    	return $this->belongsTo('App\Models\Section');
    }

    public function platform()
    {
    	return $this->belongsTo('App\Models\Platform');
    }

    //relacion muchos a muchos
    public function users()
    {
    	return $this->belongsToMany('App\Models\User');
    }


    //relacion uno a uno polimorfica
    public function resource()
    {
        return $this->morphOne('App\Models\Resource', 'resourceable');
    }

    //relacion uno a muchos polimorfica
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function reactions()
    {
        return $this->morphMany('App\Models\Reaction', 'reactionable');
    }
}
