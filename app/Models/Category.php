<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'categories';

    protected $fillable = [];

    /**
     * Get the subcategories
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get the products that has the category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
