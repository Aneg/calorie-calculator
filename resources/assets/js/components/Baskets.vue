<template>
  <div>
    <div class="loading" v-if="loading">
      Загрузка...
    </div>
    <table v-if="!loading" class="table">
      <thead>
        <tr>
          <th scope="col">Название</th>
          <th scope="col">Белки</th>
          <th scope="col">Жиры</th>
          <th scope="col">Углеводы</th>
          <th scope="col">Калорийность</th>
          <th scope="col">
            <router-link :to="{ name: 'baskets-create'}" tag='button' active-class="" class="btn btn-success btn-sm btn-block">Добавить</router-link>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="basket in basketsByPage" :key="basket.hash">
          <td>{{ basket.name }}</td>
          <td>{{ basket.protein }}</td>
          <td>{{ basket.fat }}</td>
          <td>{{ basket.carbohydrate }}</td>
          <td>{{ basket.calories }}</td>
          <td>
            <div class="btn-group flex-container" role="group">
              <router-link :to="{ name: 'basket', params: { id: basket.id }}" tag='button' active-class="" class="btn btn-outline-primary btn-sm flex-item">Изменеить</router-link>
              <button class="btn btn-outline-danger btn-sm flex-item" @click="drop(basket.id)">Удалить</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="!loading" class="btn-group " role="group" aria-label="">
      <router-link
        :to="{name: 'baskets-page', params: {page: i}}"
        tag='a'
        class="btn"
        :class="{'btn-secondary': parseInt(i) === parseInt(page), 'btn-outline-secondary': parseInt(i) !== parseInt(page)}"
        v-for="i in pageCount"
        :key="i"
      >
        {{ i }}
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Baskets',
  data () {
    return {
      sizePage: 15,
      pageCount: 1,
      loading: true
    }
  },
  watch: {
    '$route' (to, from) {
      this.fetchData()
    }
  },
  created () {
    this.fetchData()
  },
  computed: {
    page () {
      return this.$route.params.page || 1
    },
    storeBaskets () {
      return this.$store.getters.baskets
    },
    basketsByPage () {
      let start = (this.page - 1) * (this.sizePage)
      return this.storeBaskets.slice(start, start + this.sizePage)
    },
    search () {
      return this.$route.query.search || ''
    }
  },
  methods: {
    fetchData () {
      this.loading = true
      this.$store.dispatch('basketsLoad').then(
        (result) => {
          this.pageCount = Math.ceil(this.storeBaskets.length / this.sizePage);
          this.loading = false
        },
        (error) => {
          console.log(error)
        }
      )
    },
    drop (id) {
      this.$store.dispatch('dropBasket', id)
    }
  }
}
</script>

<style scoped>
.flex-item {
  width: 100%;
  }
  .flex-container {
  width: 100%;
  }
</style>
