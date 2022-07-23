<template>
    <div class="d-flex flex-column">
        <h4 class="text-center">
            Типы оборудования
        </h4>
        <div>
            <ul class="pagination d-flex justify-content-center align-items-center my-2">
                <li class="page-item" v-for="page in types.meta.last_page" :key="page">
                    <a class="cursor page-link active" v-if="page===types.meta.current_page"
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
                <th>Маска серийного номера</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(type, index) in types.data" :key="type.id">
                <td>{{ ((types.meta.current_page - 1) * types.meta.per_page) + (++index) }}</td>
                <td>{{ type.name }}</td>
                <td>{{ type.mask_sn }}</td>
            </tr>
            </tbody>
        </table>
        <div>
            <ul class="pagination d-flex justify-content-center align-items-center my-2">
                <li class="page-item" v-for="page in types.meta.last_page" :key="page">
                    <a class="cursor page-link active" v-if="page===types.meta.current_page"
                       @click="newData(page)">{{ page }}</a>
                    <a class="cursor page-link" v-else @click="newData(page)">{{ page }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "EquipmentType",
    data() {
        return {
            types: {
                meta:{},
                data:{}
            },
            search: '',
        }
    },
    created() {
        this.$axios.get(`/api/equipment-type`)
            .then(res => {
                this.types = res.data
            })
            .catch(error => {
                console.error(error)
            })
    },
    methods: {
        newData(page) {
            let url = `/api/equipment-type?page=${page}`
            url+=this.search!==''? `&&search=${this.search}`:''
            this.$axios.get(url)
                .then(res => {
                    this.types = res.data
                })
                .catch(error => {
                    console.error(error)
                })
        },
    }
}
</script>

<style scoped>

</style>
