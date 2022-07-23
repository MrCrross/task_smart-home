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
        'mask_sn'
    ];

    /**
     * @param $id
     * @return mixed
     */
    protected function mask($id){
        return static::where('id',$id)->select('mask_sn')->first()->mask_sn;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(){
        return $this->hasMany(Equipment::class);
    }

    /**
     * @param int $size
     * @param $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate(int $size,$search){
        return static::where('name','like','%'.$search.'%')
            ->orWhere('mask_sn','like','%'.$search.'%')
            ->paginate($size);
    }
}
