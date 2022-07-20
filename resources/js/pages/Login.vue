<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>

                <div class="card card-default">
                    <div class="card-header">Вход</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row my-1">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Логин</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required
                                           autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row my-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" minlength="6">
                                </div>
                            </div>

                            <div class="form-group row my-1">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Войти
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            password: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length >= 6) {
                this.$axios.post('/api/user/login', {
                    name: this.name,
                    password: this.password
                })
                    .then(response => {
                        if (response.data.success) {
                            localStorage.setItem('user', JSON.stringify(response.data.user))
                            localStorage.setItem('token', "Bearer " + response.data.token)
                            this.$router.go('/equipment')
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            } else {
                this.error = 'Пароль короткий (минимум 6 символов)'
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (localStorage.getItem('user') !== null) {
            return next('equipment');
        }
        next();
    }
}
</script>
