<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TYPE_PRODUCT = 'product';
    const TYPE_POST = 'post';

    const STATUS_SHOW = 'show';
    const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'name',
        'description',
        'slug',
        'type',
        'prioty',
        'status',
        'parent_id',
        'seo_keyword',
        'seo_description',
    ];

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
