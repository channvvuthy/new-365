<template>
    <div class="row">
        <div class="col-md-12">
            <div class="white">
                <div v-if="loading==true" class="text-center h2-title"><h2>Loading....</h2></div>
                <div v-else>
                    <div class="h2-title text-center">
                        <h2>Latest Ads</h2>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-3" v-for="(product,index) in allProducts.products">
                            <div class="product">
                                <div class="pro-img">
                                    <a :href="homeUrl+'/detail/'+product.id"><img :src="image(product.images)" alt="" class="img-responsive"></a>
                                </div>
                                <div class="pro-des">
                                    <h3><a :href="homeUrl+'/detail/'+product.id">{{product.name}}</a></h3>
                                </div>
                                <div class="pro-price">
                                    <b>${{product.price}}</b>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="h2-title text-center">
                        <h2>Popular Ads</h2>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-3" v-for="(popular,index) in allProducts.populars">
                            <div class="product">
                                <div class="pro-img">
                                    <a :href="homeUrl+'/detail/'+popular.id"><img :src="image(popular.images)" alt="" class="img-responsive"></a>
                                </div>
                                <div class="pro-des">
                                    <h3><a :href="homeUrl+'/detail/'+popular.id">{{popular.name}}</a></h3>
                                </div>
                                <div class="pro-price">
                                    <b>${{popular.price}}</b>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        methods: {
            ...mapActions(['fetchAllProduct']),
            image: function (data) {
                if (data != null) {
                    return JSON.parse(data)[0];
                }
            }
        },
        computed: mapGetters(['allProducts', 'loading']),
        created(){
            this.fetchAllProduct();
            this.homeUrl = $("#homeUrl").val();
        },
        data(){
            return {
                homeUrl: ''
            }
        }
    }
</script>
