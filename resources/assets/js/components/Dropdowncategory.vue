<template>

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
    }
</script>
