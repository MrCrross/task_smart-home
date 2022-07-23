<template>
    <div class="container">
         <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="user">
                    <router-link to="/" class="nav-item nav-link">{{user.name}}</router-link>
                    <router-link to="/equipment" class="nav-item nav-link">Оборудования</router-link>
                    <router-link to="/equipment-type" class="nav-item nav-link">Типы оборудования</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Выход</a>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/login" class="nav-item nav-link">Вход</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data(){
        return {
            user: localStorage.getItem('user')===null ? '':JSON.parse(localStorage.getItem('user')),
        }
    },
    created() {
        if(location.pathname!=='/login'&&!this.user){
            location.pathname='/login'
        }
        this.$axios.defaults.headers.common.Authorization = localStorage.getItem('token')
    },
    methods: {
        logout(e) {
            e.preventDefault()
            localStorage.removeItem('user')
            localStorage.removeItem('token')
            location.pathname='/'
        }
    },
}
</script>

<style scoped>

</style>
