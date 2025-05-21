<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Product.php
// app/Models/Product.php
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'model', 'code', 'price', 'description', 'photo', 'quantity', // Include 'quantity'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Function to check if the product has stock
    public function hasStock()
    {
        return $this->quantity > 0; // Updated to check 'quantity' instead of 'stock'
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}


