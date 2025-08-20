<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    


    protected $fillable = [
        'category_id',
        'title',
        'author',
        'isbn',
        'copies',


    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
