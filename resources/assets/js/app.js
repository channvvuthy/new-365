require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex);
Vue.component('category', require('./components/Category.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('productuser', require('./components/Productuser.vue'));
Vue.component('location', require('./components/Location.vue'));
Vue.component('myads', require('./components/Myads.vue'));
const store = new Vuex.Store({
    state: {
        categories: [],
        firstSubCat: [],
        products: [],
        productusers: [],
        locations: [],
        ads: [],
        moreads: [],
        baseUrl: "http://365daymarket.com/api",
        loadingHomePage: true
    },
    getters: {
        allCategories: state => state.categories,

        firstSubCat: state => state.firstSubCat,

        allProducts: state => state.products,

        allProductUsers: state => state.productusers,

        allLocations: state => state.locations,

        allAds: state => state.ads,
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

        async fetchAllLocation({commit}){
            const response = await axios.get(store.state.baseUrl + '/location');
            commit('setLocation', response.data)
        },

        async fetchAds({commit}, uid){
            const response = await axios.get(store.state.baseUrl + '/product/user/' + uid);
            commit('setAds', response.data.products)
        },

        async fetchMoreAds({commit}, uid){
            const response = await axios.get(store.state.baseUrl + '/product/user/' + uid);
            for (var i = 0; i < response.data.products.length; i++) {
                console.log(store.state.ads.push(response.data.products[i]))
            }

        },
    },
    mutations: {
        setCategories: (state, categories) => (state.categories = categories),

        setFirstSubCat: (state, firstSubCat) => (state.firstSubCat = firstSubCat),

        setProduct: (state, products) => (state.products = products, state.loadingHomePage = false),

        setProductUser: (state, productusers) => (state.productusers = productusers),

        setLocation: (state, locations) => (state.locations = locations),

        setAds: (state, ads) => (state.ads = ads),

    }
});

const app = new Vue({
    el: '#app',
    store
});
