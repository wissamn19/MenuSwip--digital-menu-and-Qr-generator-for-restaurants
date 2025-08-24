<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_on';

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
        'owner_id',
    ];

     /**
     * Get the restaurant that owns the order on record.
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
     * Get the owner associated with this record.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
