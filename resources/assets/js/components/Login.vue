<template>
    <div>
        <form class="form-group row login" @submit.prevent="login">
            <div class="col-sm-4">
                <input class="form-control" v-model="username" type="text" placeholder="Логин" aria-label="Логин">
                <input class="form-control" v-model="password" type="password" placeholder="Пароль" aria-label="Пароль">
                <button class="btn btn-outline-success btn-block" type="submit">Войти</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                password: '',
                username: ''
            }
        },
        methods: {
            login() {
                const {username, password} = this;
                this.$store.dispatch('authRequest', { email: username, password: password }).then(() => {
                    this.$router.push('/')
                })
            }
        }
    }
</script>

<style scoped>
</style>
