<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'products';

    protected $fillable = ['title', 'description', 'quantity', 'price', 'date', 'category_id', 'subcategory_id', 'user_id'];

    /**
     * Get the product details if is for sale
     */
    public function productForSale()
    {
        return $this->hasOne(ProductForSale::class);
    }

    /**
     * Get the images related to the product
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the user that owns the product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory of the product
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
