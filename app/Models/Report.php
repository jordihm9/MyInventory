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

    /**
     * Get the user that owns the report
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'reports_products');
    }

    public function category_stats()
    {
        return $this->belongsToMany(Category::class, 'reports_categories')->as('stat')->withPivot('value');
    }

    public function condition_stats()
    {
        return $this->belongsToMany(Condition::class, 'reports_conditions')->as('stat')->withPivot('value');
    }

    public function state_stats()
    {
        return $this->belongsToMany(State::class, 'reports_states')->as('stat')->withPivot('value');
    }
}
