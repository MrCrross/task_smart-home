<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;

class EquipmentService
{
    /**
     * @param $mask
     * @param $sn
     * @return bool
     */
    private function checked_mask_sn($mask,$sn){
        $maskArr = str_split($mask);
        $pattern = '/';
        foreach ($maskArr as $item){
            switch ($item) {
                case 'N':
                    $pattern .= '[0-9]';
                    break;
                case 'A':
                    $pattern .= '[A-Z]';
                    break;
                case 'a':
                    $pattern .= '[a-z]';
                    break;
                case 'X':
                    $pattern .= '[0-9A-Za-z]';
                    break;
                case 'Z':
                    $pattern .= '[\\-\\_\\@]';
                    break;
            }
        }
        $pattern.='/';
        if(preg_match($pattern,$sn)) return true;
        return false;
    }

    /**
     * @param $data
     * @return array
     */
    public function store($data){
        $response=[];
        foreach ($data as $key=>$equipment){
            $eq = (object)$equipment;
            if(!Equipment::checkUnique($eq->sn)){
                if($this->checked_mask_sn(EquipmentType::mask($eq->equipment_type_id),$eq->sn)){
                    Equipment::store($eq);
                    $response[]=[
                        'success'=>true,
                        'index'=>$key,
                        'message'=>'Успешно сохранено.'
                    ];
                }else{
                    $response[]=[
                        'success'=>false,
                        'index'=>$key,
                        'message'=>'Серийный номер введен не верно.'
                    ];
                }
            }else{
                $response[]=[
                    'success'=>false,
                    'index'=>$key,
                    'message'=>'Оборудование с таким серийным номеров уже существует.'
                ];
            }
        }
        return $response;
    }

    /**
     * @param $data
     * @param $id
     * @return array
     */
    public function update($data,$id){
        if(!Equipment::checkUnique($data->sn,$id)){
            if($this->checked_mask_sn(EquipmentType::mask($data->equipment_type_id),$data->sn)){
                Equipment::edit($data,$id);
                return [
                    'success'=>true,
                    'message'=>'Успешно сохранено.'
                ];
            }else{
                return[
                    'success'=>false,
                    'message'=>'Серийный номер введен не верно.'
                ];
            }
        }else{
            return[
                'success'=>false,
                'message'=>'Оборудование с таким серийным номеров уже существует.'
            ];
        }
    }
}
