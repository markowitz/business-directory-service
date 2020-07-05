<template>
    <div>
        <NavBar />
        <div class="container">
        <div v-if="search && search.length > 0">
        <div v-for="(result, index) in search" :key="index" class="listing card mb-3 text-black" style="max-width: 740px; margin-top: 20px" @click="$router.push(`/listing/${result.id}`)">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img :src="result.default_image" :alt="result.name" width="200" height="200" style="object-fit: cover">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{result.name}}</h5>
                <p class="card-text"><span class="font-weight-bold">Description:</span> {{result.description.substr(0, 200)}}<span v-if="result.description.length > 200">...</span></p>
                <p class="card-text"><i class="fa fa-map-marker-alt"></i> {{result.address}}</p>
                <p class="card-text">
                    <small class="text-muted">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </small>
                </p>
            </div>
            </div>
        </div>
    </div>
        </div>
    <div class="card mb-3" style="max-width: 740px; margin-top: 20px" v-else-if="!search || search.length === 0">
        <div class="row no-gutters">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">No search</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import NavBar from './NavBar';

    export default {
        components: {
            NavBar
        },
        data() {
            return {
                search: null
            }
        },
        mounted() {
            let url = this.$route.query.search;

            if(url !== null) {
                this.http.post('/api/search', {search: url}).then((resp) => {
                    this.search = resp.data.data;
                });
            }
        }
    }
</script>
