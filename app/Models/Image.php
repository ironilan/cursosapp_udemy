<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    //bloquea campos q no pueden ser mnodificados por asignacion masiva (propiedad create())
    protected $guarded = ['id'];

    //para tabla polimorfica
    public function imageable()
    {
    	return $this->morphTo();
    }
}
