import axios from 'axios'

axios.defaults.baseURL = '/api';

const state = {
    token: localStorage.getItem('user-token') || '',
    status: ''
};

const mutations = {
    'AUTH_REQUEST': (state) => {
        state.status = 'loading'
    },
    'AUTH_SUCCESS': (state, token) => {
        state.status = 'success';
        state.token = token
    },
    'AUTH_ERROR': (state) => {
        state.status = 'error'
    },
    'AUTH_LOGOUT': (state) => {
        state.token = ''
    },
};

const actions = {
    authRequest: ({commit, dispatch}, user) => {
        return new Promise((resolve, reject) => {
            commit('AUTH_REQUEST');
            axios({url: 'auth', data: user, method: 'POST' })
                .then(resp => {
                    const token = resp.data.data.api_token;
                    localStorage.setItem('user-token', token);

                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                    commit('AUTH_SUCCESS', token);
                    resolve(resp)
                })
                .catch(err => {
                    commit('AUTH_ERROR', err);
                    localStorage.removeItem('user-token');
                    reject(err)
                })
        })
    },
    'authLogout': ({commit}) => {
        return new Promise((resolve) => {
            commit('AUTH_LOGOUT');
            localStorage.removeItem('user-token');
            delete axios.defaults.headers.common['Authorization'];
            resolve()
        })
    }
};

const getters = {
    isAuthenticated: state => !!state.token,
    authStatus: state => state.status
};

export default {
    state,
    mutations,
    actions,
    getters
}
