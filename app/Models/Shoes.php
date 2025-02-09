<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shoes extends Model
{
    protected $table = 'shoes';
    protected $fillable = [
     'name',
     'quantity', 
     'size', 
     'color', 
     'price', 
     'description'];
}
