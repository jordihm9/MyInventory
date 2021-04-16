<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductForSale extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'products';

    protected $fillable = ['offer_price', 'sale_price', 'product_id'];

    /**
     * Get the main product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
