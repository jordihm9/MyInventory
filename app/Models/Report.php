<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'reports';

    public function products()
    {
        // return $this->belongsToMany(Product::class, 'products_reports', 'report_id', 'product_id');
        return $this->belongsToMany(Product::class, 'products_reports');
    }
}
