<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'subcategories';

    protected $fillable = [];

    /**
     * Get the parent category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the products that has the subcategory
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
