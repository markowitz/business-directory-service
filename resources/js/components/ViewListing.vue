<template>
    <div>
        <NavBar />
        <div class="container">
              <div class="card mb-3 text-black" style="max-width: 840px; margin-top: 20px">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img :src="listing.default_image" :alt="listing.name" width="200" height="200" style="object-fit: cover">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{listing.name}}
                            <span class="float-right">
                                <button class="btn btn-primary btn-sm">write a review</button>
                            </span>
                        </h5>
                        <p><small>{{categories}}</small></p>
                        <div class="listing-view-rate">
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
            <div class="card" style="max-width: 840px;">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="#about" @click.prevent="setActive('about')" :class="{ active: isActive('about') }">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#photos" @click.prevent="setActive('photos')" :class="{ active: isActive('photos') }">Link</a>
                </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
            <div class="card-body">
            <div class="tab-pane fade" :class="{ 'active show': isActive('about') }" id="about" role="tabpanel" aria-labelledby="about-tab">
                 <h2>About</h2>
                <p class="card-text">{{listing.description}}</p>
            </div>
            <div class="tab-pane fade"  :class="{ 'active show': isActive('photos') }" id="photos"  role="tabpanel" aria-labelledby="photos-tab">
                pipe down
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from './NavBar';

    export default {
        components: {
            NavBar
        },
        data() {
            return {
                listing: null,
                activeItem: 'about'
            }
        },
        methods: {
            getListing() {
                this.http.get(`/api/listing/${this.$route.params.id}`).then((res) => {
                    this.listing = res.data.data;
                });
            },
            isActive (menuItem) {
            return this.activeItem === menuItem
            },
            setActive (menuItem) {
            this.activeItem = menuItem
            }
        },
        computed: {
            categories() {
                let category = [];
                console.log(this.listing);
                this.listing.categories.filter((cat) => {
                    category.push(cat.name);
                });

                return category.toString();
            }
        },
        mounted() {
            this.getListing();
        }
    }
</script>
