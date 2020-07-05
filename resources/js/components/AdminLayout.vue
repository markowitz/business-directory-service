<template>
 <div id="wrapper">
     <SideBar />


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
          <NavBar />

        <div class="container-fluid">
                <router-view />
        </div>
      </div>
    <Footer />
    </div>
  </div>
</template>

<script>
    import SideBar from './SideBar';
    import NavBar from './NavBar';
    import Footer from './Footer';
    export default {
        components: {
            SideBar,
            NavBar,
            Footer
        },

        methods: {
            logout() {
                this.http.post('/api/logout').then((res) => {
                    this.$cookies.remove('auth');
                    this.$router.push('/');
                });
            }
        },
        mounted() {
            if (!this.$store.state.userData && this.$cookies.get('auth')) {
                this.http.get('/api/admin/user').then((resp) => {
                    this.$store.dispatch('setUser', resp.data);
                }).catch(err => {
                    console.log(err.response.status);
                });
            }
        }
    }
</script>
