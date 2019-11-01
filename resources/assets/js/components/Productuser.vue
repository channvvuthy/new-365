<template>
    <div class="row">
        <div class="col-md-12">
            <div v-if="loading==true" class="text-center"><h3>Loading...</h3></div>
            <div v-else>
                <div class="white">
                    <div v-if="loading==true" class="text-center h2-title"><h2>Loading....</h2></div>
                    <div v-else>
                        <div class="row">
                            <div class="col-md-3" v-for="(product,index) in allProductUsers.products">
                                <div class="product">
                                    <div class="pro-img">
                                        <a :href="homeUrl+'/detail/'+product.id"><img :src="image(product.images)"
                                                                                      alt="" class="img-responsive"></a>
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
                        <div class="text-center">
                            <a :href="homeUrl+'/store/'+user_id" class="btn btn-default"><i class="fa fa-eye"></i>
                                View all</a>
                        </div>
                        <br>
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
            ...mapActions(['fetchAllProductUser']),
            image: function (data) {
                if (data != null) {
                    return JSON.parse(data)[0];
                }
            }
        },
        computed: mapGetters(['allProductUsers']),
        created(){
            this.homeUrl = $("#homeUrl").val();
            if (this.fetchAllProductUser($("#user_id").val())) {
                this.loading = false
            }
        },
        data(){
            return {
                loading: true,
                user_id: $("#user_id").val(),
                homeUrl: ''
            }
        }
    }
</script>
