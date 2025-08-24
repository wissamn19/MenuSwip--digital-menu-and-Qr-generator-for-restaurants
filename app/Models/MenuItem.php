<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{      
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'restaurant_id',
        'item_name',
        'slug',
        'description',
        'price',
        'image',
        'is_hidden',
        'language',
    ];
        
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
   protected $casts = [
       'price' => 'decimal:2',
       'is_hidden' => 'boolean',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
   ];
   
   /**
    * Get the restaurant that owns the menu item.
    */
   public function restaurant()
   {
       return $this->belongsTo(Restaurant::class);
   }
   
   /**
    * Get the category that the menu item belongs to.
    */
   public function category()
   {
       return $this->belongsTo(Category::class);
   }
}
