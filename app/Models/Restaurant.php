<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'restaurants';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

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
        'restaurantName',
        'location',
        'State',
        'starttime',
        'endtime',
        'urlimage',
        'owner_id',
        'qr_code',
        'starttime',
        'endtime',
    ];

    /**
     * Get the menu items for the restaurant.
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
    

    /**
     * Get the order on records for the restaurant.
     */
    public function orderOns()
    {
        return $this->hasMany(OrderOn::class);
    }

    /**
     * Get the order off records for the restaurant.
     */
    public function orderOffs()
    {
        return $this->hasMany(OrderOff::class);
    }

    /**
     * Check if the restaurant is currently accepting orders.
     */
    public function isAcceptingOrders()
    {
        // Get the latest order on/off record
        $latestOn = $this->orderOns()->latest()->first();
        $latestOff = $this->orderOffs()->latest()->first();
        
        // If there are no records, default to accepting orders
        if (!$latestOn && !$latestOff) {
            return true;
        }
        
        // If the latest record is OrderOn, orders are enabled
        if ($latestOn && (!$latestOff || $latestOn->created_at > $latestOff->created_at)) {
            return true;
        }
        
        // Otherwise, orders are disabled
        return false;
    }


    /**
     * Get the user that owns the restaurant.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
