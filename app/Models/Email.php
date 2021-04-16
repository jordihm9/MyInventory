<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * Table associated with the model
     */
    protected $table = 'emails';

    protected $fillable = ['email', 'verification_code'];

    /**
     * Get the user that owns the email
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
