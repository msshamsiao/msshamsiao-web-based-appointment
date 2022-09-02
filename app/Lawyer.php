<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;

    public $table = 'lawyers';

    protected $fillable = [
        'lawyer_name',
        'email',
        'phone'
    ];

}
