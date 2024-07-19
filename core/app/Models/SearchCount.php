<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchCount extends Model
{
    use HasFactory;

    protected $fillable = ['search_term', 'count'];
}
