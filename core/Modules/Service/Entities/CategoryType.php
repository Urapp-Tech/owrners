<?php

namespace Modules\Service\Entities;

use App\Models\JobPost;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryType extends Model
{
    use HasFactory;
    protected $fillable = ['name','short_description','category_id','status','slug','image'];
    protected $casts = ['status'=>'integer'];


    public static function all_category_types()
    {
        return self::select(['id','category_id','status','image'])->where('status',1)->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class,'category_type_id','id')->where('status','1');
    }

    // public function projects(){
    //     return $this->belongsToMany(Project::class,'project_sub_categories')->withTimestamps();
    // }

    // public function jobs(){
    //     return $this->belongsToMany(JobPost::class,'job_post_sub_categories')->withTimestamps();
    // }

    

}
