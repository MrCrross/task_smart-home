<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * @var string
     */
    protected $table='equipments';
    /**
     * @var string[]
     */
    protected $fillable=[
        'equipment_type_id',
        'SN',
        'note'
    ];
    /**
     * @var string[]
     */
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(){
        return $this->belongsTo(EquipmentType::class,'equipment_type_id');
    }

    /**
     * @param int $size
     * @param $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate(int $size,$search){
        return static::with('type')
            ->where('SN','like','%'.$search.'%')
            ->orWhere('note','like','%'.$search.'%')
            ->paginate($size);
    }

    /**
     * @param $SN
     * @return mixed
     */
    protected function checkUnique($SN){
        return static::where('SN',$SN)->first();
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function store($data){
        return static::create([
            'equipment_type_id'=>$data->equipment_type_id,
            'SN'=>$data->SN,
            'note'=>$data->note
        ]);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    protected function edit($data,$id){
        return static::where('id',$id)->update([
            'equipment_type_id'=>$data->equipment_type_id,
            'SN'=>$data->SN,
            'note'=>$data->note
        ]);
    }
}
