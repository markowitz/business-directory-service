<template>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-8 col-lg-6 col-md-6" style="margin-top:50px">
        <div class="card o-hidden border-0 shadow-lg my-5" style="height:400px;">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 offset-md-3">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                    <div class="form-group">
                      <input v-model="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input v-model="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <button class="btn btn-primary btn-user btn-block" @click="login()">
                      Login
                    </button>
                </div>
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
    data() {
        return {
            email: null,
            password: null
        }
    },
    methods: {
        login() {
            const {email, password} =  this;
            this.http.get('/sanctum/csrf-cookie').then((res) => {
                 this.http.post('/api/login', {email, password}).then((res) => {
                     this.$cookies.set('auth', true);
                    this.$store.dispatch('setUser', res.data.user);
                    this.$router.push('/admin');
                });
            });
        }
    }
}
</script>