<template>
    <div>
        <NavBar />
        <BreadCrumb>
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#" @click="$router.go(-1)">Search</a></li>
            <li class="breadcrumb-item active" aria-current="page" v-if="listing">{{listing.name}}</li>
        </BreadCrumb>
        <div class="container" v-if="listing">
            <div class="">
                <h1>{{listing.name}}</h1>
            </div>
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
                                <button class="btn btn-primary btn-sm" @click="openReview()">write a review</button>
                            </span>
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
            <div class="tab-pane fade" :class="{ 'active show': isActive('contact') }" id="contact" role="tabpanel" aria-labelledby="about-tab">
                <div class="card-body">
                 <h4>Contact</h4>
                <p class="card-text"><span class="font-weight-bold">Business Address:</span> {{listing.address}}</p>
                <p class="card-text"><span class="font-weight-bold">Phone Numbers:</span> {{listing.phone}}</p>
                </div>
            </div>
            </div>
            </div>
        </div>
          <Modal title="Add Review" ref="showModal" id="listing" @close="closeModal">
        <form @submit.prevent="addReview">
        <div class="col-md-10 offset-md-1">
            <div class="pb-2">
            <div class="row">
                <div class="col-md-6">
                <input v-model="name" type="text" class="form-control" placeholder="your name"
            autocomplete="off" required>
                </div>
                <div class="col-md-6">
                <input v-model="email" type="email" class="form-control" placeholder="email address"
            autocomplete="off" required>
                </div>
            </div>
            </div>
          <div class="pb-2">
          <input v-model="title" type="text" class="form-control" placeholder="Title of Review"
          autocomplete="off" required>
          </div>
        <div class="pb-2">
          <textarea v-model="review" class="form-control" placeholder="briefly summarize the work that was carried out or service rendered. Minimum of 5 words" rows="5"></textarea>
          </div>
          <div class="pb-2">
          <v-select placeholder="select rate" label="name" v-model="rate"  :options="[1, 2, 3, 4, 5]" required>
          </v-select>
          </div>
          <button class="btn btn-block btn-primary" type="submit" :disabled="disabled">
                Send
          </button>
        </div>
        </form>
        </Modal>
    </div>
</template>

<script>
import NavBar from './NavBar';
import Modal from './Modal';
import vSelect from 'vue-select';
import BreadCrumb from './BreadCrumb';

    export default {
        components: {
            NavBar,
            Modal,
            vSelect,
            BreadCrumb
        },
        data() {
            return {
                listing: null,
                activeItem: 'about',
                title: null,
                review: null,
                name: null,
                email: null,
                rate: null,
                disabled: false
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
            },
            openReview() {
                this.$refs.showModal.active = true;
            },
            addReview() {
                const { email, name, review, title, rate} = this;
                const listing_id = this.listing.id;

                if(email === '' || name === '', review === '', title === '' , rate == null) {
                    this.$toastr.e('Please fill in all fields');
                }
                this.http.post(`/api/reviews/add`, { email, name, review, title, rate, listing_id}).then((res) => {
                        this.email, this.name, this.review, this.title, this.rate = null;
                        this.closeModal();
                        this.getListing();
                        this.$toastr.s('review added successfully');
                });
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

                return category.toString();
            }
        },
        mounted() {
            this.getListing();
        }
    }
</script>
