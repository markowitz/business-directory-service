<template>
    <div class="px-3 py-4 flex justify-center">
        <div class="pb-4">
            <button type="button" class="btn btn-primary"  @click="openModal('showModal')">Add Listings</button>
        </div>
        <table class="table-auto text-md bg-white shadow-md rounded mb-4">
            <tbody>
                <tr class="border-b">
                    <th class="text-left p-3 px-5"></th>
                    <th class="text-left p-3 px-5">Name</th>
                    <th class="text-left p-3 px-5">Description</th>
                    <th class="text-left p-3 px-4">Address</th>
                    <th class="text-left p-3 px-4">Phone</th>
                    <th class="text-left p-3 px-4">Published</th>
                    <th class="text-left p-3 px-4" v-if="checkUser('super_admin')"></th>
                </tr>
                <tr  v-for="(listing, index) in listings" :key="index">
                    <td class="p-3 px-4">
                        <img :src="listing.default_image" :alt="listing.name" width="100" height="100" style="object-fit: cover " />
                    </td>
                    <td class="p-3 px-4">{{listing.name}}</td>
                    <td class="py-3 px-4">{{listing.description}}</td>
                    <td class="p-3 px-4">{{listing.address}}</td>
                    <td class="p-3 px-4">{{listing.phone}}</td>
                    <td class="p-3 px-4">
                        <span class="badge badge-success" v-if="listing.published">approved</span>
                        <span class="badge badge-warning" v-if="!listing.published">unapproved</span>
                    </td>
                    <td class="p-3 px-4 flex justify-end" v-if="checkUser('super_admin') || !listing.published">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" v-if="!listing.published" @click="openEditListing(listing)">Edit Listing</a>
                                <a class="dropdown-item" href="#" v-if="checkUser('super_admin') && !listing.published" @click="approve(listing.id, true)">Approve & Publish</a>
                                <a class="dropdown-item" href="#" v-if="checkUser('super_admin') && listing.published" @click="approve(listing.id, false)">UnApprove & UnPublish</a>
                                <a class="dropdown-item" href="#" @click="deleteListing(listing.id)" v-if="checkUser('super_admin')">Delete</a>
                            </div>
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>

      <Modal title="Add Listing" ref="showModal" id="listing" @close="closeModal">
        <form @submit.prevent="addListing">
        <div class="col-md-9 offset-md-1">
          <div class="pb-2">
          <input v-model="name" type="text" class="form-control" placeholder="Business Name"
          autocomplete="off" required>
          </div>
          <div class="pb-2">
          <v-select  label="name" v-model="selectedCategory" :reduce="category => category.id" :options="categories" multiple>
               <template #no-options="">
                no approved category matching your request
            </template>
          </v-select>
          </div>
          <div class="pb-2">
          <textarea v-model="description" class="form-control" placeholder="description" rows="5"></textarea>
          </div>
           <div class="pb-2">
          <input v-model="email" type="email" class="form-control" placeholder="Email address"
          autocomplete="off" required>
          </div>
          <div class="pb-2">
          <input v-model="url" type="url" class="form-control" placeholder="website address"
          autocomplete="off" required>
          </div>
           <div class="pb-2">
          <input v-model="address" type="text" class="form-control" placeholder="Business Address"
          autocomplete="off" required>
          </div>
           <div class="pb-2">
          <input v-model="phone" type="text" class="form-control" placeholder="+2348111111"
          autocomplete="off" required>
          </div>
        <label for="images">Upload multiple images* </label>
          <div class="input-group pb-2">
            <div class="custom-file">
                <input type="file" ref="images" class="custom-file-input" id="inputGroupFile04" accept="image/*" multiple required />
                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
            </div>
            </div>
          <button class="btn btn-block btn-primary" type="submit" :disabled="disabled">
                Send
          </button>
        </div>
        </form>
        </Modal>

         <Modal title="Edit Listing" ref="editModal" id="listing" @close="closeModal">
        <form @submit.prevent="editListing">
        <div class="col-md-9 offset-md-1">
          <div class="pb-2">
          <input v-model="listing.name" type="text" class="form-control" placeholder="Business Name"
          autocomplete="off" required>
          </div>
          <div class="pb-2">
          <v-select  label="name" v-model="listing.categories" :reduce="category => category.id" :options="categories" multiple>
               <template #no-options="">
                no approved category matching your request
            </template>
          </v-select>
          </div>
          <div class="pb-2">
          <textarea v-model="listing.description" class="form-control" placeholder="description" rows="5"></textarea>
          </div>
           <div class="pb-2">
          <input v-model="listing.email" type="email" class="form-control" placeholder="Email address"
          autocomplete="off" required>
          </div>
          <div class="pb-2">
          <input v-model="listing.url" type="url" class="form-control" placeholder="website address"
          autocomplete="off" required>
          </div>
           <div class="pb-2">
          <input v-model="listing.address" type="text" class="form-control" placeholder="Business Address"
          autocomplete="off" required>
          </div>
           <div class="pb-2">
          <input v-model="listing.phone" type="text" class="form-control" placeholder="+2348111111"
          autocomplete="off" required>
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
    import Modal from './Modal';
    import vSelect from 'vue-select';

        export default {
        components: {
            Modal,
            vSelect
        },
        data() {
            return {
                listings: null,
                name: null,
                description: null,
                email: null,
                phone: null,
                address: null,
                url: null,
                disabled: false,
                selectedCategory: [],
                categories: [],
                listing: []
            }
        },
        methods: {
            openModal(ref) {
                if(ref === 'showModal') {
                    this.$refs.showModal.active = true;
                }else {
                    this.$refs.editModal.active = true;
                }
            },

            closeModal() {
            this.$refs.showModal.active = false;
            // this.role = 'member';
            },

            openEditListing(listing) {
                this.openModal();
                this.listing = listing;
               this.selectedCategory = listing.categories;
            },
            fetchCategories() {
                this.http.get('/api/admin/categories').then((res) => {
                    res.data.data.forEach((item) => {
					this.categories.push(item);
				});
                });
            },

            getListings() {
                this.http.get('/api/admin/listings').then((res) => {
                    this.listings = res.data.data;

                });
                this.fetchCategories();
            },
            addListing() {
              const formData = new FormData();
               for(let i = 0; i < this.$refs.images.files.length; i++) {
				 	let file = this.$refs.images.files[i];
					formData.append('images[' + i + ']', file);
                }

                formData.append('name', this.name);
                formData.append('description', this.description);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('address', this.address);
                formData.append('url', this.url);
                formData.append('categories', this.selectedCategory);

                this.disabled = true;

                this.http.post('/api/admin/listings/add', formData, {
                            headers: {
                            "Content-Type": "multipart/form-data"
                            }}).then((res) => {
                                this.getListings();
                                this.closeModal();
                                this.$toastr.s(res.data.message);
                            });

            },
            editListing() {
                this.http.patch(`/api/admin/listings/${this.listing.id}`, this.listing).then((res) => {
                    console.log(res.data);
                });
            },
            approve(listing_id, status){
                this.confirm('you want to approve this listing?').then(() => {
                this.http.patch(`/api/admin/listings/${listing_id}`, {published : status}).then((res) => {
                    this.getListings();
                    this.$toastr.s(res.data.message);
                });
                });
            },
             deleteListing(listing_id) {
                this.confirm('you want to delete this listing?').then(() => {
                this.http.delete(`/api/admin/listings/${listing_id}`).then((res) => {
                    this.getListings();
                    this.$toastr.s(res.data.message);
                });
            });
            }
        },
        mounted() {
            this.getListings();
        }
    }
</script>
