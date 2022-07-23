<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'=>'TP-Link TL-WR74',
                'mask_sn'=>'XXAAAAAXAA'
            ],
            [
                'name'=>'D-Link DIR-300',
                'mask_sn'=>'NXXAAXZXaa'
            ],
            [
                'name'=>'D-Link DIR-300 E',
                'mask_sn'=>'NAAAAXZXXX'
            ],
        ];

        $equipments = [
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGGG0GF',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGGG0FG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGGG1GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGGF0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGGFG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GGFGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00GFGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'00FGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'01GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGGG0GF',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGGG0FG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGGG1GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGGF0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'sn'=>'10GGGFF0GG',
                'note'=>'jngkjdfngjkds'
            ],

        ];

        foreach ($types as $type){
            EquipmentType::create($type);
        }
        foreach ($equipments as $equipment){
            Equipment::create($equipment);
        }
    }
}
