<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='equipments';
    protected $fillable=[
        'equipment_type_id',
        'SN',
        'note'
    ];

    protected $dates=['deleted_at'];

    public function type(){
        return $this->belongsTo(EquipmentType::class,'equipment_type_id');
    }

    protected function paginate(int $size,$search){
        return static::with('type')
            ->where('SN','like','%'.$search.'%')
            ->orWhere('note','like','%'.$search.'%')
            ->paginate($size);
    }

    protected function checkUnique($SN){
        return static::where('SN',$SN)->first();
    }

    protected function store($data){
        return static::create([
            'equipment_type_id'=>$data->equipment_type_id,
            'SN'=>$data->SN,
            'note'=>$data->note
        ]);
    }
    protected function edit($data,$id){
        return static::where('id',$id)->update([
            'equipment_type_id'=>$data->equipment_type_id,
            'SN'=>$data->SN,
            'note'=>$data->note
        ]);
    }
}
