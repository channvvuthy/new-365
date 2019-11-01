<template>
    <div>
        <label class="">City/Province : </label>
        <select name="location" class="form-control">
            <option value="">All City/Province</option>
            <option :value="location.name" v-for="(location,index) in allLocations.locations">{{location.name}}</option>
        </select>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        methods: {
            ...mapActions(['fetchAllLocation']),
        },
        computed: mapGetters(['allLocations']),
        created(){
            this.fetchAllLocation();
        },
    }
</script>
