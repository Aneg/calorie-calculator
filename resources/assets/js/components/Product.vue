<template>
  <div class="product">
    <h2>Добавленеие продукта</h2>
    <hr/>
    <form @submit.prevent="save">
      <div class="form-group row">
          <div class="col-sm-12">
            <div class="form-group">
              <input
                v-model.number='product.name'
                class="form-control"
                v-bind:class="{'is-invalid': errors.name}"
                placeholder="Название"
              >
              <div class="invalid-feedback" v-if="errors.name">
                {{ errors.name[0] }}
              </div>
            </div>
          </div>
          <hr/>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="text-center col-form-label">Белки</label>
              <input
                class="form-control"
                v-bind:class="{'is-invalid': errors.protein}"
                placeholder="Белки"
                v-model.number='product.protein'
              >
              <div class="invalid-feedback" v-if="errors.protein">
                {{ errors.protein[0] }}
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="text-center col-form-label">Жиры</label>
              <input
                class="form-control"
                placeholder="Жиры"
                v-model.number='product.fat'
                v-bind:class="{'is-invalid': errors.fat}"
              >
              <div class="invalid-feedback" v-if="errors.fat">
                {{ errors.fat[0] }}
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="text-center col-form-label">Углеводы</label>
              <input
                class="form-control"
                placeholder="Углеводы"
                v-model.number='product.carbohydrate'
                v-bind:class="{'is-invalid': errors.carbohydrate}"
              >
              <div class="invalid-feedback" v-if="errors.carbohydrate">
                {{ errors.carbohydrate[0] }}
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="text-center col-form-label">Калорийность</label>
              <input
                class="form-control"
                placeholder="Калорийность"
                v-model.number='product.calories'
                v-bind:class="{'is-invalid': errors.calories}"
              >
              <div class="invalid-feedback" v-if="errors.calories">
                {{ errors.calories[0] }}
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <hr/>
            <button type="submit" :disabled="disableSubmit" class="btn btn-primary">Сохранить</button>
          </div>
      </div>
    </form>
  </div>
</template>

<script>

export default {
  name: 'Product',
  data () {
    return {
      product: this.cleenProduct,
      disableSubmit: false,
      errors: {}
    }
  },
  created () {
    this.syncProduct()
  },
  watch: {
    'storeProduct' (to, from) {
      this.syncProduct()
    }
  },
  computed: {
    cleenProduct () {
      return { name: '', protein: '', fat: '', carbohydrate: '', calories: '' }
    },
    productId () {
      return parseInt(this.$route.params.id)
    },
    storeProduct () {
      return this.$store.getters.product(this.productId)
    },
    isValidDecimalProtein () {
      return this.isValidDecimal(this.product.protein)
    }
  },
  methods: {
    save () {
      this.disableSubmit = true
      this.$store.dispatch(this.productId ? 'updateProduct' : 'addProduct', this.product).then(
        (result) => {
          this.disableSubmit = false;
          this.errors = {};
          this.$router.push({name: 'products'})
        },
        (result) => {
          this.disableSubmit = false;
          this.errors = result.response.data
        }
      )
    },
    syncProduct (products = null) {
      let storeProduct = this.storeProduct;
      this.product = this.productId && storeProduct
        ? this.storeProduct
        : this.cleenProduct
    },
    isValidDecimal (value) {
      return value - parseFloat(value) === 0
    }
  }
}
</script>

<style scoped>
</style>
