<template>
    <div>
        <table class="table" id="table">
            <thead>
            <tr>
                <th>Ads Photo</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product,index) in allAds">
                <td><img :src="image(product.images)" alt="" style="height:60px;"></td>
                <td><p ><a :href="homeUrl+'/detail/'+product.id" class="color">{{product.name}}</a></p></td>
                <td>${{product.price}}</td>
                <td>
                    <ul class="list-inline">
                        <li><a :href="homeUrl+'/product/user/delete/'+product.id" class="btn btn-xs btn-danger"
                               onclick="return confirm('Are you sure to delete this item?')"> <i
                                class="fa fa-trash"></i>
                            Delete</a></li>
                        <li><a :href="homeUrl+'/update/product/'+product.id" class="btn btn-xs btn-primary"> <i
                                class="fa fa-pencil"></i> Edit</a></li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button class="btn btn-default" @click="countRow"><i class="fa fa-eye"></i> View More</button>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        methods: {
            ...mapActions(['fetchAds', 'fetchMoreAds']),
            image: function (data) {
                if (data != null) {
                    return JSON.parse(data)[0];
                }
            },
            countRow: function () {
                var row = document.getElementById('table').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
                this.fetchMoreAds(this.uid + "?offset=" + row + "&limit=20")
                console.log(row)
            }
        },
        computed: mapGetters(['allAds']),
        created(){
            this.fetchAds(this.uid)
            this.homeUrl = $("#homeUrl").val();
        },
        data(){
            return {
                homeUrl: '',
                uid: $("#uid").val(),
            }
        }
    }
</script>
