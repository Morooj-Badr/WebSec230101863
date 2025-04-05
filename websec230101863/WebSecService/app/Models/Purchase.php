<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
// app/Models/Purchase.php
// app/Models/Purchase.php
public function user()
{
    return $this->belongsTo(User::class);
}


public function product()
{
    return $this->belongsTo(Product::class);
}


}
