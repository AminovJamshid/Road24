<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $fillable = ['last_name', 'first_name', 'date_of_birth', 'passport', 'phone', 'chat_id'];

}
