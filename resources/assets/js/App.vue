<template>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <router-link to="" tag='a' active-class="" class="navbar-brand font-weight-bold">Calculator</router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <router-link :to="{ name: 'products'}" tag='a' active-class="active" class="nav-item">
            <span class="nav-link">Продукты</span>
          </router-link>
          <router-link :to="{name: 'baskets'}" tag='a' active-class="active" class="nav-item">
            <span class="nav-link">Калькулятор</span>
          </router-link>
        </ul>
      </div>
    </nav>
    <router-view class="container" />
  </div>
</template>

<script>

export default {
  name: 'App',
  methods: {
      logout: function () {
          this.$store.dispatch('authLogout')
              .then(() => {
                  this.$router.push('/login')
              })
      }
  },
}
</script>

<style>
</style>
