import { dropOrUpdateObjectById } from '../../helpers/helper'
import axios from 'axios'

axios.defaults.baseURL = '/api';
console.log(axios.defaults.headers);
// const headers = {'Authorization': 'Bearer KOPxSTlopKbfJjpgjtj6dxcKyXzjSGCnXC4GfNHB3bi8f0RCqjrOJeuEBdHR'};

const state = {
  products: [],
  next_id: 0
};

const mutations = {
  'SET_PRODUCTS' (state, products) {
    state.products = products
  },
  'ADD_PRODUCT' (state, product) {
    state.products.unshift(product)
  },
  'DROP_PRODUCT' (state, id) {
    dropOrUpdateObjectById(state.products, id)
  },
  'UPDATE_PRODUCT' (state, newProduct) {
    state.products = state.products.map((product) => {
      return product.id === newProduct.id ? newProduct : product
    })
  }
};

const actions = {
  addProduct: ({commit, getters}, id) => {
    return new Promise((resolve, reject) => {
      axios.post('/products/', id).then((response) => {
        commit('ADD_PRODUCT', response.data.data);
        resolve()
      }, (err) => {
        console.log(err);
        reject(err)
      })
    })
  },
  setProducts: ({commit, getters}, sync) => {
    axios.get('/products').then((response) => {
      commit('SET_PRODUCTS', response.data.data)
    }, (err) => {
      console.log(err)
    })
  },
  updateProduct: ({commit}, product) => {
    return new Promise((resolve, reject) => {
      axios.put('/products/' + product.id + '/', product).then(
        (response) => {
          commit('UPDATE_PRODUCT', response.data.data);
          resolve()
        },
        (err) => {
          console.log(err.response);
          reject(err)
        })
    })
  },
  dropProduct: ({commit}, id) => {
    axios.delete('/products/' + id + '/').then((response) => {
      commit('DROP_PRODUCT', id)
    }, (err) => {
      console.log(err)
    })
  }
};

const getters = {
  products: (state) => {
    return state.products
  },
  product: (state) => (id) => {
    return state.products.find((el) => { return el.id === id })
  },
  totalCount: (state, getters) => (id, weight) => {
    let product = getters.product(id);
    return { name: product.name,
      protein: product.protein * weight / 100,
      fat: product.fat * weight / 100,
      carbohydrate: product.carbohydrate * weight / 100,
      calculus: product.calculus * weight / 100
    }
  },
  totalCountByName: (state, getters) => (id, name, weight) => {
    return getters.product(id)[name] * weight / 100
  }
};

export default {
  state,
  mutations,
  actions,
  getters
}
