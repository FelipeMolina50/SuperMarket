<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'sku', 'cat', 'stock', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function updateStockFromMovements()
    {
        $entries = $this->movements()->where('type', 'entry')->sum('quantity');
        $exits = $this->movements()->where('type', 'exit')->sum('quantity');
        
        $this->update(['stock' => $entries - $exits]);
    }
}
