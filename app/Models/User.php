<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Table associated with the model
     */
    protected $table = 'users';

    protected $fillable = ['name', 'surnames', 'sex', 'password', 'language', 'email_id'];

    /**
     * Get the email associated to the user
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    /**
     * Get the products of the user
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
