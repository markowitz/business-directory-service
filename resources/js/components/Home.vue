<template>
    <div class="jumbotron">
        <div class="align-jumbotron">
        <h1 class="display-4 text-center">Welcome to Listings</h1>
        <p class="lead text-center">find any business information!</p>
        <p class="text-center font-italic"><small> name, address, phone, website, email, description</small></p>
        <div class="input-group mb-3 col-md-4 offset-md-4">
            <input type="text" v-model="search" class="form-control" placeholder="Business name, address, email..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
        <div class="input-group-append">
            <button class="btn btn-outline-primary btn-primary text-white" @click="goToSearchListing" type="button">Search</button>
        </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: null
            }
        },
        methods: {
            goToSearchListing() {
            if (this.search != null) {
                this.$router.push({path:'search', query: {search: this.search}});
            }
            },
        },
    mounted() {
            console.log('Component mounted.')
        }
    }
</script>
