import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import axios from 'axios';
import VueCookies from 'vue-cookies';
import store from './store';
import toastr from 'vue-toastr';
import VueSweetalert2 from 'vue-sweetalert2';


// require('./bootstrap');

 require("vue-select/src/scss/vue-select.scss");

 let Api = axios.create({baseURL: 'http://localhost:8000/'});

 Api.defaults.withCredentials = true;

Vue.mixin({
    data() {
        return {
            http: axios
        }
    },
    methods: {
        checkUser(data) {
            if(this.$store.state.userData)
                return this.$store.state.userData.user_type === data;
        },
        confirm(text, title = 'Are you sure!') {
            return new Promise((resolve, reject) => {
              Vue.swal({
                title,
                text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
              }).then((resp) => {
                if (resp.isConfirmed) {
                  resolve(resp);
                } else {
                  reject(resp);
                }
              }).catch((err) => {
                reject(err);
              });
            });
          },
    }
});


Vue.use(VueRouter);
Vue.use(VueCookies);
Vue.use(toastr);
Vue.use(VueSweetalert2);

let app = new Vue({
    el: '#app',
    store,
    router: new VueRouter(routes)
});
