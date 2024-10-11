<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;
    protected $fillable = ['plate_number', 'amount', 'date', 'type_id', 'car_id'];
}
