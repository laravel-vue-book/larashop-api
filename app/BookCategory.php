<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_category';

    protected $fillable = [
        'book_id', 'category_id', 'invoice_number', 'status'
    ];
    
}
