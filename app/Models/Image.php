<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'images';

    protected $fillable = ['url', 'product_id'];

    /**
     * Get the product of the image
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
