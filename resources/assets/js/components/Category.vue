<template>
    <div class="row" v-if="type=='home'">
        <div class="col-md-12">
            <ul class="list-unstyled parent_drop">
                <li class="first"><a href="#"><i class="glyphicon glyphicon-list"></i> Choose Category</a></li>
            </ul>
        </div>
        <div class="col-md-3 pr-0 toggle">
            <ul class="list-unstyled side">
                <li v-for="(category,index) in allCategories.categories">
                    <a href="" id="parent" :data-id="category.id" @click.prevent="fetchFirstSubCat(category.id)"><i
                            :class="category.icon"></i> {{category.name}}</a>
                </li>
            </ul>
        </div>
        <div class="col-md-9 pl-0 toggle">
            <div class="bg-white">
                <div class="sub" v-if="firstSubCat">
                    <div class="col-md-3 text-center pd" v-for="(subCat,index) in firstSubCat.sub_category">
                        <a :href="homeUrl+'category/'+subCat.name"><i :class="subCat.icon"></i> {{subCat.name}}</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <select name="category" class="form-control" v-else>
        <option value="">All Category</option>
        <option :value="subCat.name" v-for="(subCat,index) in subCategory.sub_category">{{subCat.name}}</option>
    </select>


</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapActions} from "vuex";
    export default {
        props: {
            type: String
        },
        methods: {
            ...mapActions(['fetchCategories', 'fetchFirstSubCat']),
            async getSubCategory(){
                const response = await axios.get(this.homeUrl + '/api/category?id=sub');
                this.subCategory = response.data;
            }
        },
        computed: mapGetters(['allCategories', 'firstSubCat']),
        created(){
            this.fetchCategories();
            this.fetchFirstSubCat(1);
            if (this.type == 'filter') {
                this.getSubCategory();
            }
        },
        data(){
            return {
                homeUrl: "http://365daymarket.com/",
                subCategory: []
            }
        }
    }
</script>
