<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
  
    protected $dates = ['deleted_at'];
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body','user_id','main_category','sub_category','latitude','longitude','marker_title','address'];
    
    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
