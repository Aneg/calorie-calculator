<template>
<tr>
  <td>{{ product.name }}</td>
  <td>
    <input v-model.number="weight" class="form-control" @change="change" type="number">
  </td>
  <td>{{ protein | fixedone }}</td>
  <td>{{ fat | fixedone }}</td>
  <td>{{ carbohydrate | fixedone }}</td>
  <td>{{ calories | fixedone }}</td>
  <td>
    <button class="btn btn-outline-danger btn-sm  btn-block" @click="drop(basketItem)">Удалить</button>
  </td>
</tr>
</template>

<script>
export default {
  name: 'BasketItem',
  props: ['basketItem'],
  data () {
    return {
      name: '',
      productId: 0,
      weight: 0,
      carbohydrate: 0,
      protein: 0,
      fat: 0,
      calories: 0
    }
  },
  created () {
    this.initData(this.basketItem)
  },
  watch: {
    'weight' (to, from) {
      this.calculate()
    },
    'product' (to, from) {
      this.calculate()
    }
  },
  computed: {
    product () {
      return this.$store.getters.product(this.productId) || { name: '', protein: 0, fat: 0, carbohydrate: 0, calories: 0, hash: null }
    }
  },
  methods: {
    calculate () {
      this.fat = parseInt(this.weight) ? parseFloat(this.product.fat) * parseInt(this.weight) / 100 : 0;
      this.protein = parseInt(this.weight) ? parseFloat(this.product.protein) * parseInt(this.weight) / 100 : 0;
      this.carbohydrate = parseInt(this.weight) ? parseFloat(this.product.carbohydrate) * parseInt(this.weight) / 100 : 0;
      this.calories = parseInt(this.weight) ? parseFloat(this.product.calories) * parseInt(this.weight) / 100 : 0;
    },
    drop (basketItem) {
      this.$emit('drop', basketItem)
    },
    change () {
      this.$emit('sync', {
        productId: this.productId,
        weight: this.weight,
        protein: this.protein,
        fat: this.fat,
        carbohydrate: this.carbohydrate,
        calories: this.calories,
        hash: this.basketItem.hash
      })
    },
    initData (item) {
      this.productId = item.productId;
      this.weight = item.weight;
      this.carbohydrate = item.carbohydrate ? item.carbohydrate : 0;
      this.protein = item.protein ? item.carbohydrproteinate : 0;
      this.fat = item.fat ? item.fat : 0;
      this.calories = item.calories ? item.calories : 0;
    }
  }
}
</script>
