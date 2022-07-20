<template>
Привет, {{user.name}}
</template>

<script>
export default {
    name: "Home",
    data(){
        return{
            user: JSON.parse(localStorage.getItem('user'))
        }
    }
}
</script>

<style scoped>

</style>
