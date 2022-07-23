<template>
    <div class="d-flex flex-column">
        <h4 class="text-center">Оборудования
            <router-link class="btn btn-success" to="/equipment/create">Добавить</router-link>
        </h4>
        <div>
            <ul class="pagination d-flex justify-content-center align-items-center my-2">
                <li class="page-item" v-for="page in equipments.meta.last_page" :key="page">
                    <a class="cursor page-link active" v-if="page===equipments.meta.current_page"
                       @click="newData(page)">{{ page }}</a>
                    <a class="cursor page-link" v-else @click="newData(page)">{{ page }}</a>
                </li>
            </ul>
        </div>
        <div>
            <div class="input-group my-1">
                <input type="search" class="form-control" placeholder="Найти" v-model="search">
                <button type="submit" class="btn btn-primary" @click="newData(1)">Найти</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>№</th>
                <th>Название</th>
                <th>Серийный номер</th>
                <th>Описание</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(equipment, index) in equipments.data" :key="equipment.id">
                <td>{{ ((equipments.meta.current_page - 1) * equipments.meta.per_page) + (++index) }}</td>
                <td>{{ equipment.type.name }}</td>
                <td>{{ equipment.sn }}</td>
                <td>{{ equipment.note }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editEquipment', params: { id: equipment.id }}"
                                     class="btn btn-primary">Изменить
                        </router-link>
                        <button class="btn btn-danger" @click="deleteEquipment(equipment.id)">Удалить</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <ul class="pagination d-flex justify-content-center align-items-center my-2">
                <li class="page-item" v-for="page in equipments.meta.last_page" :key="page">
                    <a class="cursor page-link active" v-if="page===equipments.meta.current_page"
                       @click="newData(page)">{{ page }}</a>
                    <a class="cursor page-link" v-else @click="newData(page)">{{ page }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "Equipment",
    data() {
        return {
            equipments: {
                meta:{},
                data:{}
            },
            search: '',
        }
    },
    created() {
        this.$axios.get(`/api/equipment`)
            .then(res => {
                this.equipments = res.data
            })
            .catch(error => {
                console.error(error)
            })
    },
    methods: {
        newData(page) {
            let url = `/api/equipment?page=${page}`
            url+=this.search!==''? `&&search=${this.search}`:''
            this.$axios.get(url)
                .then(res => {
                    this.equipments = res.data
                })
                .catch(error => {
                    console.error(error)
                })
        },
        deleteEquipment(id) {
            this.$axios.delete(`/api/equipment/${id}`)
                .then(res => {
                    if (res.data.success) {
                        this.equipments.data.forEach((e,i)=>{
                            if(e.id===id){
                                const temp = [...this.equipments.data]
                                temp.splice(i,1)
                                this.equipments.data=[...temp]
                                return
                            }
                        })
                    }
                })
                .catch(error => {
                    console.error(error)
                })
        }
    }
}
</script>

<style scoped>

</style>
