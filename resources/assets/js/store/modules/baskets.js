import { dropOrUpdateObjectById } from '../../helpers/helper'

import axios from 'axios'

axios.defaults.baseURL = '/api';
// const headers = {'Authorization': 'Bearer KOPxSTlopKbfJjpgjtj6dxcKyXzjSGCnXC4GfNHB3bi8f0RCqjrOJeuEBdHR'};
const state = {
  baskets: [],
  basketTemplate: {}
};

const mutations = {
  'SET_BASKETS' (state, baskets) {
    state.baskets = baskets
  },
  'DROP_BASKET' (state, id) {
    dropOrUpdateObjectById(state.baskets, id)
  },
  'SET_BASCET_TEMLPATE' (state, basket) {
    state.basketTemplate = basket
  }
};

const actions = {
  basketsLoad: ({commit, getters}) => {
    return new Promise((resolve, reject) => {
      axios.get('/baskets').then((response) => {
        commit('SET_BASKETS', response.data.data);
        resolve()
      }, (err) => {
        console.log(err);
        reject(err)
      })
    })
  },
  dropBasket: ({commit}, id) => {
    axios.delete('/baskets/' + id + '/').then((response) => {
      commit('DROP_BASKET', id)
    }, (err) => {
      console.log(err)
    })
  },
  basketTLoad: ({commit, getters}, id) => {
    return new Promise((resolve, reject) => {
      if (id) {
        axios.get('/baskets/' + id + '/').then((response) => {
          commit('SET_BASCET_TEMLPATE', response.data.data);
          resolve(response.data.data)
        }, (err) => {
          console.log(err);
          reject(err)
        })
      } else {
        commit('SET_BASCET_TEMLPATE', {name: '', items: []});
        resolve({name: '', items: []})
      }
    })
  },
  basketTSave: ({commit}, basket) => {
    if (basket.id) {
      return new Promise((resolve, reject) => {
        axios.put('/baskets/' + basket.id + '/', basket).then(
          (response) => {
            commit('SET_BASCET_TEMLPATE', response.data.data);
            resolve()
          },
          (err) => {
            console.log(err.response);
            reject(err)
          })
      })
    } else {
      return new Promise((resolve, reject) => {
        axios.post('/baskets/', basket).then((response) => {
          commit('SET_BASCET_TEMLPATE', response.data.data);
          resolve()
        }, (err) => {
          console.log(err);
          reject(err)
        })
      })
    }
  }
};

const getters = {
  baskets: state => {
    return state.baskets
  },
  basket: (state) => (id) => {
    return state.baskets.find((el) => { return el.id === id })
  },
  basketT: (state) => {
    return state.basketTemplate.name ? state.basketTemplate : null
  }
};

export default {
  state,
  mutations,
  actions,
  getters
}
