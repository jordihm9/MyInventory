<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'states';

    protected $fillable = [];

    /**
     * Get the products that has the category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
