<template>
    <div>
         <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow" v-if="$route.fullPath.includes('admin')">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{userData ? userData.name : ''}}</span>
                <img class="img-profile rounded-circle" src="/img/anon_user.jpg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" @click="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
             <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow" v-if="!$route.fullPath.includes('admin')">
             <router-link class="nav-link" to="/admin/login">Admin Login</router-link>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
    </div>
</template>
<script>
import { mapState } from 'vuex';
export default {
    methods: {
        logout() {
        this.http.get('/api/sanctum/csrf-cookie').then((resp) =>{
        this.http.post('/api/logout').then((res) => {
            this.$cookies.remove('auth');
            this.$router.push('/');
        });
      });
    }
},
computed: {
    ...mapState(['userData']),
},
}
</script>