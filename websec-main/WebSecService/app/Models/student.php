<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students'; // Explicitly define table name

    protected $primaryKey = null; // Disable primary key expectation
    public $incrementing = false; // Prevent Laravel from expecting an auto-incremented ID

    protected $fillable = ['name', 'age', 'major'];
}
 