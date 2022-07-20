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
                'maskSN'=>'XXAAAAAXAA'
            ],
            [
                'name'=>'D-Link DIR-300',
                'maskSN'=>'NXXAAXZXaa'
            ],
            [
                'name'=>'D-Link DIR-300 E',
                'maskSN'=>'NAAAAXZXXX'
            ],
        ];

        $equipments = [
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGGG0GF',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGGG0FG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGGG1GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGGF0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGGFG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GGFGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00GFGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'00FGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'01GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGGG0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGGG0GF',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGGG0FG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGGG1GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGGF0GG',
                'note'=>'jngkjdfngjkds'
            ],
            [
                'equipment_type_id'=>1,
                'SN'=>'10GGGFF0GG',
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
