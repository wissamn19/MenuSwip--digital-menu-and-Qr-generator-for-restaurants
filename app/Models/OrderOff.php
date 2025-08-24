<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOff extends Model
{
    use HasFactory;


     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_off';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'chef_id',
    ];

    
    /**
     * Get the restaurant that owns the order off record.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the order associated with this record.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the chef associated with this record.
     */
    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }
}
