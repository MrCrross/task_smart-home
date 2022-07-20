<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table='equipment_types';
    protected $fillable=[
        'name',
        'maskSN'
    ];

    protected function mask($id){
        return static::where('id',$id)->select('maskSN')->first()->maskSN;
    }
}