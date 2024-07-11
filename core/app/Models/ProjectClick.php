<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectClick extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','user_id', 'ip_address', 'user_agent'];

    public function project() {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
