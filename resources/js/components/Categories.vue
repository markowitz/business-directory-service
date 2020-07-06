<template>
    <div class="px-3 py-4 flex justify-center">
        <div class="pb-4">
            <button type="button" class="btn btn-primary"  @click="openModal">Add Category</button>
        </div>
        <table class="table-auto text-md bg-white shadow-md rounded mb-4 offset-md-2">
            <tbody>
                <tr class="border-b">
                    <th class="text-left p-3 px-5">Name</th>
                    <th class="text-left p-3 px-5">Added By</th>
                    <th class="text-left p-3 px-4">Published</th>
                    <th class="text-left p-3 px-4" v-if="checkUser('super_admin')"></th>
                </tr>
                <tr class="table-hover"  v-for="(category, index) in categories" :key="index">
                    <td class="p-3 px-4">{{category.name}}</td>
                    <td class="py-3 px-4">{{category.user.name}}</td>
                    <td class="p-3 px-4">
                        <span class="badge badge-success" v-if="category.published">approved</span>
                        <span class="badge badge-warning" v-if="!category.published">unapproved</span>
                    </td>
                    <td  class="p-3 px-4 flex justify-end" v-if="checkUser('super_admin') || !category.published">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" v-if="!category.published">Edit Category</a>
                                <a class="dropdown-item" href="#" v-if="checkUser('super_admin') && !category.published" @click="approve(category.id, true)">Approve & Publish</a>
                                <a class="dropdown-item" href="#" v-if="checkUser('super_admin') && category.published" @click="approve(category.id, false)">UnApprove & UnPublish</a>
                                <a class="dropdown-item" href="#" @click="deleteCategory(category.id)" v-if="checkUser('super_admin')">Delete</a>
                            </div>
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>

      <Modal title="Add Category" ref="showModal" id="listing" @close="closeModal">
        <form @submit.prevent="addCategories">
        <div class="col-md-9 offset-md-1">
          <div class="pb-2">
          <input v-model="name" type="text" class="form-control" placeholder="add category"
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

        export default {
        components: {
            Modal,
        },
        data() {
            return {
                categories: null,
                name: null,
                disabled: false
            }
        },
        methods: {
            openModal() {
            this.$refs.showModal.active = true;
            },
            closeModal() {
            this.$refs.showModal.active = false;
            // this.role = 'member';
            },
            getCategories() {
                this.http.get('/api/admin/categories/all').then((res) => {
                    this.categories = res.data.data;
                });
            },
            addCategories() {
              const { name } = this;

              this.http.post('/api/admin/categories/add', {name}).then((res) => {
                  this.getCategories();
                  this.closeModal();
                  this.$toastr.s(res.data.message);
              })

            },
            approve(category_id, status){
                this.confirm('you want to approve this category?').then(() => {
                this.http.patch(`/api/admin/categories/${category_id}`, {published : status}).then((res) => {
                    this.getCategories();
                    this.$toastr.s(res.data.message);
                });
                });
            },
            deleteCategory(category_id) {
                this.confirm('you want to delete this category?').then(() => {
                this.http.delete(`/api/admin/categories/${category_id}`).then((res) => {
                    this.getCategories();
                });
            });
            }
        },
        mounted() {
            this.getCategories();
        }
    }
</script>
