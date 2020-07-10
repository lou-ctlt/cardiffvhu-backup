<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    
    protected $fillable =['photo_path'];

    protected $primaryKey = "photo_id";
}
