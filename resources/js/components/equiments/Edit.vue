<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
                <div class="card card-default">
                    <div class="card-header">
                        Изменения оборудования
                        <button type="button" class="btn btn-sm btn-info"
                                data-bs-toggle="popover"
                                data-bs-title="Описание маски"
                                data-bs-content='N – цифра от 0 до 9;
A – прописная буква латинского алфавита;
a – строчная буква латинского алфавита;
X – прописная буква латинского алфавита либо цифра от 0 до 9;
Z –символ из списка: “-“, “_”, “@”.'>
                            О серийном номере
                        </button></div>
                    <form>
                        <div class="card-body">
                            <div class="card my-1">
                                <div class="card-body w-full">
                                    <div class="form-group row my-1">
                                        <label for="equipment_type_id" class="col-sm-4 col-form-label text-md-right">Тип
                                            оборудования</label>
                                        <div class="col-md-6">
                                            <select id="equipment_type_id" v-model="equipment.equipment_type_id"
                                                    @change="changeMask"
                                                    class="form-select">
                                                <option :value="type.id" :data-mask="type.mask_sn" v-for="type in types"
                                                        :key="type.id">
                                                    {{ type.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert pt-0 pb-1 px-2 alert-success" v-if="equipment.maskedSN" role="alert">
                                            {{equipment.maskedSN}}
                                        </div>
                                        <div class="alert pt-0 pb-1 px-2 alert-danger" v-if="equipment.error" role="alert">
                                            {{equipment.error}}
                                        </div>
                                        <div class="form-group row my-1">
                                            <label for="sn" class="col-md-4 col-form-label text-md-right">
                                                Серийный номер
                                            </label>
                                            <div class="col-md-8">
                                                <input id="sn" type="text" class="form-control" :data-index="equipment.id" @input="checkMaskedSN" v-model="equipment.sn"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row my-1">
                                        <label for="note"
                                               class="col-md-4 col-form-label text-md-right">Примечание</label>
                                        <div class="col-md-8">
                                            <textarea id="note" class="form-control" v-model="equipment.note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="btn-group my-1">
                                <button type="submit" class="btn btn-primary" @click="editEquipment">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import {Popover} from 'bootstrap/dist/js/bootstrap.esm.min.js'

export default {
    name: "Edit",
    data() {
        return {
            error: null,
            equipment: {
            },
            types: {},
            id:0
        }
    },
    created() {
        this.id = location.pathname.slice(location.pathname.lastIndexOf('/')+1)
        this.$axios.get('/api/equipment/'+this.id)
        .then(res=>{
            this.equipment=res.data.data
            this.equipment.mask=res.data.data.type.mask_sn
        })
        .catch(error=>{
            console.log(error)
        })
        this.$axios.post('/api/equipment-type')
            .then(res => {
                this.types = res.data.data
            })
            .catch(error => {
                console.error(error)
            })
    },
    mounted() {
        console.log(this.equipment)
        Array.from(document.querySelectorAll('button[data-bs-toggle="popover"]'))
            .forEach(popoverNode => new Popover(popoverNode))
    },
    methods: {
        patternOne(el){
            let pattern=''
            switch (el) {
                case 'N':
                    pattern = '[0-9]';
                    break;
                case 'A':
                    pattern = '[A-Z]';
                    break;
                case 'a':
                    pattern = '[a-z]';
                    break;
                case 'X':
                    pattern = '[0-9A-Za-z]';
                    break;
                case 'Z':
                    pattern = '[\\-\\_\\@]';
                    break;
            }
            return pattern;
        },
        patternAll(mask){
            let pattern = '';
            mask.forEach(el => {
                switch (el) {
                    case 'N':
                        pattern += '[0-9]+';
                        break;
                    case 'A':
                        pattern += '[A-Z]+';
                        break;
                    case 'a':
                        pattern += '[a-z]+';
                        break;
                    case 'X':
                        pattern += '[0-9A-Za-z]+';
                        break;
                    case 'Z':
                        pattern += '[\\-\\_\\@]+';
                        break;
                }
            })
            return pattern.slice(0,-1);
        },
        changeMask(e) {
            const mask = e.target.options[e.target.options.selectedIndex].dataset.mask
            const equipment= this.equipment
            equipment.mask=mask
            equipment.error=''
            equipment.maskedSN=''
            const sn = document.getElementById('sn')
            sn.title = mask
            sn.placeholder = mask
            equipment.pattern = this.patternAll(mask.split(''))
        },
        checkMaskedSN(e){
            const equipment=this.equipment
            const mask=equipment.mask.split('')
            equipment.maskedSN=''
            equipment.error=''
            const sn = equipment.sn.split('')
            mask.forEach((el,key) => {
                if(key+1>equipment.sn.length){
                    return;
                }
                equipment.masked=true
                if(!sn[key].match(this.patternOne(el))){
                    equipment.maskedSN=`Маска: ${equipment.mask}. Неверный серийный номер. Ошибка в символе ${key+1}`;
                    equipment.masked=false
                    return
                }
            })
            if(equipment.sn.length>equipment.mask.length){
                equipment.maskedSN=`Маска: ${equipment.mask}.`;
                equipment.error='Серийный номер заполнен неверно.'
                return;
            }
            if(equipment.masked){
                equipment.maskedSN=`Маска: ${equipment.mask}. Серийный номер заполняется верно.`;
                if(equipment.sn.length===equipment.mask.length ){
                    if(equipment.sn.match(equipment.pattern)){
                        equipment.maskedSN=`Серийный номер заполнен верно.`;
                        equipment.error=''
                    }
                    if(!equipment.sn.match(equipment.pattern)){
                        equipment.maskedSN=`Маска: ${equipment.mask}. Серийный номер заполнен неверно.`;
                        equipment.error=''
                    }
                }
                return
            }
        },
        editEquipment(e) {
            e.preventDefault()
            this.$axios.put('/api/equipment/'+this.id,{
                "equipment_type_id":this.equipment.equipment_type_id,
                "sn":this.equipment.sn,
                "note":this.equipment.note
            })
                .then(res=>{
                    const data = res.data.data
                    this.equipment.maskedSN=''
                    this.equipment.error=''
                    if(data.success){
                        this.equipment.maskedSN=data.message
                    }
                    if(!data.success){
                        this.equipment.error =data.message;
                    }
                })
                .catch(e=>{
                    if(e.response.data.message ==="The given data was invalid."){
                        this.error="Введенные данные не корректны."
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
