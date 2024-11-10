<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;


    protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timesamps = true;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
