<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
                <div class="card card-default">
                    <div class="card-header">
                        Добавление оборудования
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
                            <div class="card my-1" v-for="(line,index) in equipments" :key="index">
                                <div class="card-body w-full">
                                    <div class="form-group row my-1">
                                        <label for="equipment_type_id" class="col-sm-4 col-form-label text-md-right">Тип
                                            оборудования</label>
                                        <div class="col-md-6">
                                            <select id="equipment_type_id" v-model="line.equipment_type_id"
                                                    @change="changeMask"
                                                    :data-index="index"
                                                    class="form-select">
                                                <option :value="type.id" :data-mask="type.maskSN" v-for="type in types"
                                                        :key="type.id">
                                                    {{ type.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    @click="removeEquipment(index)">
                                                Удалить
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert pt-0 pb-1 px-2 alert-success" v-if="line.maskedSN" role="alert">
                                            {{line.maskedSN}}
                                        </div>
                                        <div class="alert pt-0 pb-1 px-2 alert-danger" v-if="line.error" role="alert">
                                            {{line.error}}
                                        </div>
                                    <div class="form-group row my-1">
                                        <label for="SN" class="col-md-4 col-form-label text-md-right">
                                            Серийный номер
                                        </label>
                                        <div class="col-md-8">
                                            <input id="SN" type="text" class="form-control" :data-index="index" @input="checkMaskedSN" v-model="line.SN"
                                                   required>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group row my-1">
                                        <label for="note"
                                               class="col-md-4 col-form-label text-md-right">Примечание</label>
                                        <div class="col-md-8">
                                            <textarea id="note" class="form-control" v-model="line.note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="btn-group my-1">
                                <button type="submit" class="btn btn-primary" @click="storeEquipments">
                                    Сохранить
                                </button>
                                <button type="button" class="btn btn-success" @click="addEquipment">
                                    Добавить
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
    name: "Create",
    data() {
        return {
            error: null,
            equipments: [{
                equipment_type_id: 0,
                SN: '',
                note: '',
                mask: ''
            }],
            types: {},
        }
    },
    created() {
        this.$axios.get('/api/equipment-type')
            .then(res => {
                this.types = res.data
            })
            .catch(error => {
                console.error(error)
            })
    },
    mounted() {
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
        addEquipment() {
            this.equipments.push({
                equipment_type_id: 0,
                SN: '',
                note: ''
            })
            Array.from(document.querySelectorAll('button[data-bs-toggle="popover"]'))
                .forEach(popoverNode => new Popover(popoverNode))
        },
        removeEquipment(key) {
            const temp = [...this.equipments]
            temp.splice(key, 1)
            this.equipments = [...temp]
        },
        changeMask(e) {
            const mask = e.target.options[e.target.options.selectedIndex].dataset.mask
            const equipment= this.equipments[e.target.dataset.index]
            equipment.mask=mask
            equipment.error=''
            equipment.maskedSN=''
            const SN = e.target.parentNode.parentNode.parentNode.querySelector('#SN')
            SN.title = mask
            SN.placeholder = mask
            equipment.pattern = this.patternAll(mask.split(''))
        },
        checkMaskedSN(e){
            const equipment= this.equipments[e.target.dataset.index]
            const mask=equipment.mask.split('')
            equipment.maskedSN=''
            equipment.error=''
            const SN = equipment.SN.split('')
            mask.forEach((el,key) => {
                if(key+1>equipment.SN.length){
                    return;
                }
                equipment.masked=true
                if(!SN[key].match(this.patternOne(el))){
                    equipment.maskedSN=`Маска: ${equipment.mask}. Неверный серийный номер. Ошибка в символе ${key+1}`;
                    equipment.masked=false
                    return
                }
            })
            if(equipment.SN.length>equipment.mask.length){
                equipment.maskedSN=`Маска: ${equipment.mask}.`;
                equipment.error='Серийный номер заполнен неверно.'
                return;
            }
            if(equipment.masked){
                equipment.maskedSN=`Маска: ${equipment.mask}. Серийный номер заполняется верно.`;
                if(equipment.SN.length===equipment.mask.length ){
                    if(equipment.SN.match(equipment.pattern)){
                        equipment.maskedSN=`Серийный номер заполнен верно.`;
                        equipment.error=''
                    }
                    if(!equipment.SN.match(equipment.pattern)){
                        equipment.maskedSN=`Маска: ${equipment.mask}. Серийный номер заполнен неверно.`;
                        equipment.error=''
                    }
                }
                return
            }
        },
        storeEquipments(e) {
            e.preventDefault()
            this.$axios.post('/api/equipment',{
                equipments:this.equipments
            })
                .then(res=>{
                    const data = res.data
                    data.forEach(el=>{
                        this.equipments[el.index].maskedSN=''
                        this.equipments[el.index].error=''
                        if(el.success){
                            this.equipments[el.index].maskedSN=el.message
                        }
                        if(!el.success){
                            this.equipments[el.index].error =el.message;
                        }
                    })
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
