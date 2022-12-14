<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are protected against mass assigning.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
}
