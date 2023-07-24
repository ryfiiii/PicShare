<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $guarded = [
    ];

    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'img_id');
    }

}
