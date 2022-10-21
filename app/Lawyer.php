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

    public function client_lawyer()
    {
        return $this->hasOne(Client::class, 'id' ,'client_id');
    }

}
