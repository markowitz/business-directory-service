import Vue from 'vue';
import VueCookie from 'vue-cookies';
import axios from 'axios';

Vue.use(axios);

export const middleware = (middlewares = []) => (to, from, next) => {
    middlewares.forEach((rule) => {
      rule(to, from, next);
    });
  };

  export const authProtect = (from, to, next) => {
    const auth = VueCookie.get('auth');
    console.log();
    if (auth) {
      next();
    } else {
      next('/admin/login');
    }
  };

  export const redirect = (from, to, next) => {
     // Add a response interceptor
    axios.interceptors.response.use(function (response) {
      return response;
    }, function (error) {
        if(error.response.status === 401) {
            VueCookie.remove('auth');
            next('/admin/login');
        }
    });

  }

  export const guest = (from, to, next) => {
    const auth = VueCookie.get('auth');
    if (!auth) {
      next();
    } else {
      next('/admin');
    }
  };

