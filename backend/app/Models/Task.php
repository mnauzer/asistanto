<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

protected $fillable = ['title', 'description'];

class Task extends Model
{
    use HasFactory;
}
