<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SearchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'city', 
        'type',
        'purpose',
        'bedroom',
        'bathroom',
        'minprice',
        'maxprice',
        'minarea',
        'maxarea',
        'featured',
    ];
    use HasFactory;
}
