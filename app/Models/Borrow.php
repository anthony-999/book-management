<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    //

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',


    ];

    protected $casts = [
        'borrowed_at' => 'date:Y-m-d',
        'due_at' => 'date:Y-m-d',
        'returned_at' => 'date:Y-m-d',
    ];

    public function getStatusAttribute($value)
    {
        if ($this->returned_at) {
             // If book returned AFTER due date → overdue
            if ($this->returned_at->gt($this->due_at)) {
                return 'overdue';
            }
              return 'returned';
        }

        if (now()->gt($this->due_at)) {
            return 'overdue';
        }

        return 'borrowed';
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
