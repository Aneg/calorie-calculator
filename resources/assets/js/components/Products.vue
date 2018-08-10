<template>
  <div>
    <form @submit.prevent="submitSearch" class="form-group row">
      <div class="col-sm-10">
        <input class="form-control" type="text" v-model="search" placeholder="Поиск" aria-label="Поиск">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-outline-success btn-block" type="submit">Поиск</button>
      </div>
    </form>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'Products',
  data () {
    return {
      search: ''
    }
  },
  computed: {
    querySearch () {
      return this.$route.query.search || ''
    }
  },
  created () {
    this.$store.dispatch('setProducts');
    this.search = this.querySearch;
  },
  methods: {
    submitSearch () {
      this.$router.push({name: 'products', query: {search: this.search}})
    }
  }
}
</script>

<style scoped>
</style>
