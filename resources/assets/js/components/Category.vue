<template>
    <div class="row">
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
                        <a :href="homeUrl+'/category/'+subCat.name"><i :class="subCat.icon"></i> {{subCat.name}}</a>
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
            ...mapActions(['fetchCategories', 'fetchFirstSubCat']),
        },
        computed: mapGetters(['allCategories', 'firstSubCat']),
        created(){
            this.fetchCategories();
            this.fetchFirstSubCat(1);
        },
        data(){
            return {
                homeUrl: "http://127.0.0.1:8000"
            }
        }
    }
</script>
