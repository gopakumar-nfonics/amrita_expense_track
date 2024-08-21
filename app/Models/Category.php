<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tbl_category';

    protected $fillable = ['category_name', 'category_code', 'parent_category', 'remarks'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }

    /**
     * Get the child categories for this category.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }
}
