require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex);
Vue.component('category', require('./components/Category.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('productuser', require('./components/Productuser.vue'));
const store = new Vuex.Store({
    state: {
        categories: [],
        firstSubCat: [],
        products: [],
        productusers: [],
        baseUrl: "http://127.0.0.1:8000/api",
        loadingHomePage: true
    },
    getters: {
        allCategories: state => state.categories,

        firstSubCat: state => state.firstSubCat,

        allProducts: state => state.products,

        allProductUsers: state => state.productusers,

        loading: state => state.loadingHomePage
    },
    actions: {
        async fetchCategories({commit}){
            const response = await axios.get(store.state.baseUrl + '/category');
            commit('setCategories', response.data)
        },

        async fetchFirstSubCat({commit}, id){
            const response = await axios.get(store.state.baseUrl + '/category?id=' + id);
            commit('setFirstSubCat', response.data)
        },

        async fetchAllProduct({commit}){
            const response = await axios.get(store.state.baseUrl + '/product');
            commit('setProduct', response.data)
        },
        async fetchAllProductUser({commit}, id){
            const response = await axios.get(store.state.baseUrl + '/product/user/' + id);
            commit('setProductUser', response.data)
        },
    },
    mutations: {
        setCategories: (state, categories) => (state.categories = categories),

        setFirstSubCat: (state, firstSubCat) => (state.firstSubCat = firstSubCat),

        setProduct: (state, products) => (state.products = products, state.loadingHomePage = false),

        setProductUser: (state, productusers) => (state.productusers = productusers),
    }
});

const app = new Vue({
    el: '#app',
    store
});
