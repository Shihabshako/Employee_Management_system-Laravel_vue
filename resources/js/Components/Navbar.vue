<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav d-flex align-items-center" style="gap: 20px">
      <li class="nav-item">
        <span class="nav-link" data-widget="pushmenu" role="button"
          ><i class="fas fa-bars"></i
        ></span>
      </li>
      <li class="nav-item">
        <span class="text-lg font-weight-bold">{{ userName }}</span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell fa-lg"></i>
          <span class="badge badge-danger navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 4 new messages </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 8 friend requests </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 3 new reports </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 4 new messages </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 8 friend requests </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 3 new reports </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 4 new messages </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 8 friend requests </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 3 new reports </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> 3 new reports </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>

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
      userName: localStorage.getItem("loggedInUserName"),
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
            localStorage.removeItem("loggedInUserName");
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