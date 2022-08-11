<template lang="">
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                <h2 class="h1">Enkaizen</h2>
                </div>
                <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form @submit.prevent="handleForm">
                    <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" v-model="formData.email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" v-model="formData.password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mt-2 mb-3">
                    <button  class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </button>
                    <button  class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </button>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <span >I forgot my password</span>
                </p>
                <p class="mb-0">
                    <span class="text-center">Register a new membership</span>
                </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
    </div>
</template>
<script>
import { useRouter } from "vue-router";

export default {
  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      router: useRouter(),
    };
  },
  methods: {
    async handleForm() {
      // await axios.get('/sanctum/csrf-cookie')
      await axios
        .post("/api/login", this.formData)
        .then(async (response) => {
          if (response.data.success) {
            localStorage["loggedInUserEmail"] = response.data.data.email;
            localStorage["loggedInUserToken"] = response.data.token;
            localStorage["loggedInUserName"] = response.data.data.name;
            localStorage["loggedInUserId"] = response.data.data.id;
            localStorage["loggedInUserRole"] = response.data.data.role_name;
            localStorage["isLoggedInUserManager"] =
              response.data.data.isManager;

            this.router.push({ name: "Home" });
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style lang="">
</style>