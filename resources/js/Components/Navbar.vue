<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <span class="nav-link" data-widget="pushmenu" role="button"
          ><i class="fas fa-bars"></i
        ></span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <!-- <span>Shihab</span> -->
        <span
          class="nav-link d-flex justify-content-center align-items-center"
          data-toggle="dropdown"
        >
          <img
            src="assets/dist/img/avatar4.png"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="width: 33px; cursor: pointer"
          />
        </span>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <router-link :to="{ name: 'Profile' }" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Profile
          </router-link>
          <div class="dropdown-divider"></div>
          <router-link :to="{ name: 'Change Password' }" class="dropdown-item">
            <i class="fas fa-key mr-2"></i> Change Password
          </router-link>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item" @click="logout" style="cursor: pointer">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </span>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
</template>
<script>
import { useRouter } from "vue-router";
export default {
  data() {
    return {
      router: useRouter(),
      access_token: localStorage.getItem("loggedInUserToken"),
    };
  },
  methods: {
    async logout() {
      await axios
        .post("/api/logout")
        .then((response) => {
          if (response.data.success) {
            toastr.info("You have been logged out!!");
            localStorage.removeItem("loggedInUserEmail");
            localStorage.removeItem("loggedInUserToken");
            this.router.push({ name: "Login" });
          } else {
            toastr.info(response.data.message);
          }
        })
        .catch((error) => {
          console.log("error => ", error);
        });
    },
  },
};
</script>
<style lang="">
</style>