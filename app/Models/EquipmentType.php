<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table='equipment_types';
    /**
     * @var string[]
     */
    protected $fillable=[
        'name',
        'maskSN'
    ];

    /**
     * @param $id
     * @return mixed
     */
    protected function mask($id){
        return static::where('id',$id)->select('maskSN')->first()->maskSN;
    }
}
