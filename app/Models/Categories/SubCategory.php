<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory(){
        return $this->belongsTo('App\Models\Categories\MainCategory');
    }

    public function posts(){
        return $this->belongsToMany('App\Models\Post\Post','posts','sub_categories_id','posts_id');
        // リレーションの定義
    }
}