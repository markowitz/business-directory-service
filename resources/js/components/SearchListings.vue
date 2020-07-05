<template>
    <div>
        <NavBar />
        <BreadCrumb>
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">"{{$route.query.search}}"</li>
        </BreadCrumb>
        <div class="container">
        <div v-if="search && search.length > 0">
             <h3>Search Result for "{{$route.query.search}}"</h3>
            <p>{{search.length}} results found for your search "{{$route.query.search}}"</p>
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
                        <span class="fa fa-star" :class="{checked : result.review_avg >= 1}"></span>
                        <span class="fa fa-star" :class="{checked : result.review_avg >= 2}"></span>
                        <span class="fa fa-star" :class="{checked : result.review_avg >= 3}"></span>
                        <span class="fa fa-star" :class="{checked : result.review_avg >= 4}"></span>
                        <span class="fa fa-star" :class="{checked : result.review_avg >= 5}"></span>
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
                <h5 class="card-title">Not Found!</h5>
                <p class="card-text">Sorry, we could not find any result matching "{{$route.query.search}}".</p>
                <p class="card-text"><router-link to="/" class="send-to-home"><small>Try again with another search term.</small></router-link></p>
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
import BreadCrumb from './BreadCrumb';

    export default {
        components: {
            NavBar,
            BreadCrumb
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
