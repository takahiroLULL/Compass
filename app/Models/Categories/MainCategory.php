<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
        return $this->belongsTomany('SubCategory','sub_categories','main_categories.main_category','sub_categories.main_category_id');
        // リレーションの定義
    }

}