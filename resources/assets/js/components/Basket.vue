<template>
  <div class="basket">
    <div class="loading" v-if="loading">
      Загрузка...
    </div>
    <h2 v-if="basket">
      {{ basketId ? 'Редактирование ' + basket.name : 'Добавленеие продукта' }}
      <button
        @click="save"
        class="btn btn-primary btn-sm float-right"
      >
        Сохранить
      </button>
      </h2>
    <hr/>
    <form v-if="basket" @submit.prevent="save">
      <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <input
                v-model.number='basket.name'
                class="form-control"
                placeholder="Название"
                :disabled="disableSubmit"
              >
            </div>
          </div>
      </div>
    </form>
    <table v-if="basket" class="table">
      <thead>
        <tr>
          <th scope="col">Продукт</th>
          <th scope="col">Вес</th>
          <th scope="col">Белки</th>
          <th scope="col">Жиры</th>
          <th scope="col">Углеводы</th>
          <th scope="col">Калорийность</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select v-model="form.productId" class="form-control">
              <option value=""></option>
              <option v-for="product in products" :key="product.hash" :value="product.id">{{ product.name }}</option>
            </select>
          </td>
          <td>
            <input :disabled="!formProduct" v-model.number="form.weight" class="form-control" type="number">
          </td>
          <td>{{ form.protein | fixedone }}</td>
          <td>{{ form.fat | fixedone }}</td>
          <td>{{ form.carbohydrate | fixedone }}</td>
          <td>{{ form.calories | fixedone }}</td>
          <td>
              <button :disabled="!formProduct" class="btn btn-outline-success btn-block btn-sm flex-item" @click="addItem">Добавить</button>
          </td>
        </tr>
        <tr>
          <td>В общем</td>
          <td></td>
          <td>{{ all.protein | fixedone }}</td>
          <td>{{ all.fat | fixedone }}</td>
          <td>{{ all.carbohydrate | fixedone }}</td>
          <td>{{ all.calories | fixedone }}</td>
          <td></td>
        </tr>
        <basket-item
          v-for="item in basket.items"
          :key="item.productId"
          :basketItem="item"
          @drop="dropItem"
          @sync="syncItem"
        />
      </tbody>
    </table>
  </div>
</template>

<script>
import BasketItem from './BasketItem.vue'

export default {
  name: 'Basket',
  data () {
    return {
      basket: null,
      loading: true,
      disableSubmit: false,
      form: { productId: null, weight: null, protein: 0, fat: 0, carbohydrate: 0, calories: 0, hash: null },
      all: { protein: 0, fat: 0, carbohydrate: 0, calories: 0 }
    }
  },
  watch: {
    '$route': 'fetchData',
    'isFormChanged' (to, from) {
      let need = this.formProduct && this.form.weight;
      this.form.protein = need ? this.formProduct.protein * this.form.weight / 100 : 0;
      this.form.fat = need ? this.formProduct.fat * this.form.weight / 100 : 0;
      this.form.carbohydrate = need ? this.formProduct.carbohydrate * this.form.weight / 100 : 0;
      this.form.calories = need ? this.formProduct.calories * this.form.weight / 100 : 0;
    },
    'basket.items' (to, from) {
      this.fetchPFC()
    }
  },
  created () {
    this.fetchData()
  },
  computed: {
    isFormChanged () { return this.form.productId + this.form.weight },
    formProduct () { return this.products.find((el) => parseInt(el.id) === parseInt(this.form.productId)) },
    basketId () { return parseInt(this.$route.params.id) },
    products () { return this.$store.getters.products }
  },
  methods: {
    fetchPFC () {
      this.all = { protein: 0, fat: 0, carbohydrate: 0, calories: 0 };
      this.basket.items.map((el) => {
        this.all.protein += el.protein;
        this.all.fat += el.fat;
        this.all.carbohydrate += el.carbohydrate;
        this.all.calories += el.calories
      })
    },
    fetchData () {
      this.basket = null;
      this.loading = true;
      this.$store.dispatch('basketTLoad', this.basketId).then(
        (result) => {
          this.basket = result;
          this.loading = false
        },
        (error) => {
          console.log(error)
        }
      )
    },
    addItem () {
      let item = {
        hash: this.$store.getters.getHash,
        productId: this.form.productId,
        weight: this.form.weight,
        protein: this.form.protein,
        fat: this.form.fat,
        carbohydrate: this.form.carbohydrate,
        calories: this.form.calories
      };

      let product = this.basket.items
        ? this.basket.items.find((el) => el.productId === this.form.productId)
        : null;
      if (!product) {
        if (this.basket.items) {
          this.basket.items.push(item)
        } else {
          this.basket.items = [item]
        }
      } else {
        product.weight = parseInt(product.weight) + parseInt(this.form.weight)
      }
      this.form = { productId: null, weight: null, protein: 0, fat: 0, carbohydrate: 0, calories: 0, hash: null }
    },
    dropItem (item) {
      this.basket.items.splice(this.basket.items.indexOf(item), 1)
    },
    save () {
      this.disableSubmit = true;
      this.$store.dispatch('basketTSave', this.basket).then(
        (result) => {
          this.disableSubmit = false;
          this.errors = {};
          this.$router.push({name: 'baskets'})
        },
        (result) => {
          this.disableSubmit = false;
          this.errors = result.response.data
        }
      )
    },
    syncItem (item) {
      this.basket.items.splice(this.basket.items.indexOf(this.basket.items.find((el) => el.productId === item.productId)), 1, item)
    }
  },
  components: {
    BasketItem: BasketItem
  }
}
</script>

<style scoped>
</style>
