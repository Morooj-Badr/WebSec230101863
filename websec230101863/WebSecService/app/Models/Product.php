<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'model', 'code', 'price', 'description', 'photo', 'stock'];

    // Check if the product has stock available
    public function hasStock()
    {
        return $this->stock > 0;
    }
}
