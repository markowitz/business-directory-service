<template>
    <div>
         <div class="card mb-3 text-black" style="max-width: 840px; margin-top: 20px">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img :src="listing.default_image" :alt="listing.name" width="200" height="200" style="object-fit: cover">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{listing.name}}
                        </h5>
                        <p><small>{{categories}}</small></p>
                        <div class="listing-view-rate">
                        <p class="card-text">
                            <small class="text-muted">
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 1}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 2}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 3}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 4}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 5}"></span>
                            </small>
                        </p>
                          <div class="card-text px-4 text-center">
                            <p>{{listing.views_count}} Visits</p>
                        </div>
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
                    <a class="nav-link" href="#photos" @click.prevent="setActive('photos')" :class="{ active: isActive('photos') }">Photos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact" @click.prevent="setActive('contact')" :class="{ active: isActive('contact') }">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#reviews" @click.prevent="setActive('reviews')" :class="{ active: isActive('reviews') }">Reviews</a>
                </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" :class="{ 'active show': isActive('about') }" id="about" role="tabpanel" aria-labelledby="about-tab">
                <div class="card-body">
                 <h4>About</h4>
                <p class="card-text"><span class="font-weight-bold">Description:</span> {{listing.description}}</p>
                </div>
            </div>
            <div class="tab-pane fade"  :class="{ 'active show': isActive('photos') }" id="photos"  role="tabpanel" aria-labelledby="photos-tab">
                <div class="card-body">
                <p class="card-text mt-1">
                    <div class="row">
                        <div class="col-md-3" v-for="(image, index) in listing.images_url" :key="index">
                            <img :src="image"  width="150" height="150" style="object-fit: cover">
                        </div>
                    </div>
                    </p>
                </div>
            </div>
            <div class="tab-pane fade" :class="{ 'active show': isActive('contact') }" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="card-body">
                 <h4>Contact</h4>
                <p class="card-text"><span class="font-weight-bold">Business Address:</span> {{listing.address}}</p>
                <p class="card-text"><span class="font-weight-bold">Phone Numbers:</span> {{listing.phone}}</p>
                </div>
            </div>
                <div class="tab-pane fade" :class="{ 'active show': isActive('reviews') }" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="card-body">
                 <h4>Reviews</h4>
                    <div class="row" v-for="(review, index) in listing.reviews" :key="index">
                        <div class="col-md-3">
                            <img :src="review.gravatar_url" class="rounded" width="150" height="150" />
                        </div>
                        <div class="col-md-9">
                            <h6>{{review.name}}</h6>
                             <p><small class="text-muted">
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 1}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 2}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 3}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 4}"></span>
                                <span class="fa fa-star" :class="{checked : listing.review_avg >= 5}"></span>
                            </small></p>
                            <p>
                                <em>
                                    {{review.review}}
                                </em>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
    </div>
</template>

<script>
export default {
    data()  {
        return {
            listing: null,
            activeItem: 'about',
        }
    },
    methods: {
        getListing() {
                this.http.get(`/api/admin/listings/${this.$route.params.id}`).then((res) => {
                    this.listing = res.data.data;
                });
            },
            isActive (menuItem) {
            return this.activeItem === menuItem
            },
            setActive (menuItem) {
            this.activeItem = menuItem
            },
            closeModal() {
            this.$refs.showModal.active = false;
            },
    },
     computed: {
            categories() {
                let category = [];
                this.listing.categories.filter((cat) => {
                    category.push(cat.name);
                });

                return category.join(', ');
            }
        },
     mounted() {
            this.getListing();
        }
}
</script>