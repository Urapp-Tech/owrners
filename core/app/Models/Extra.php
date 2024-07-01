<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'price',
        'is_basic_standard_premium'
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

}
