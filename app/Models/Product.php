<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    
   

    public static function boot()
{
    parent::boot();
    self::creating(function ($model) {
        $model->kode_produk = IdGenerator::generate(['table' => $this->table, 'length' => 6, 'prefix' =>date('y')]);
    });
}
}
