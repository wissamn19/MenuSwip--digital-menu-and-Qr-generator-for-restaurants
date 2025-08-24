<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'owners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName',
        'Email',
        'password',
        'verified',
        'email_verification_token',
        'reset_token',
        'reset_token_expires_at',
        'code',
        'remember_token',
        'dob',
        'gender',
        'phonen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'reset_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'reset_token_expires_at' => 'datetime',
    ];

    /**
     * Get the restaurants owned by this owner.
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'owner_id');
    }
}
