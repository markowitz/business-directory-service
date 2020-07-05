<template>
    <div class="flex flex-col items-center justify-center min-h-screen w-full">
  <!-- Form -->
  <div class="w-full"
       style="max-width: 16rem;">
    <h1 class="mb-3 font-normal text-center">Log in</h1>
    <div>
      <label class="block mb-4">
        <div class="mb-1 text-grey-darkest">Email</div>
        <input v-model="email" class="w-full py-2 px-3 border rounded outline-none focus:border-blue-light focus:shadow-outline"
           type="text">
      </label>
      <label class="block mb-5">
        <div class="mb-1 text-grey-darkest">Password</div>
        <input v-model="password" class="w-full py-2 px-3 border rounded outline-none focus:border-blue-light focus:shadow-outline"
           type="password">
      </label>
      <div class="mb-10">
        <button class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="login()">
          Log in
        </button>
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