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
      <li class="nav-item dropdown" @click="markRead()">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell fa-lg"></i>
          <span class="badge badge-danger navbar-badge badge-larger">{{
            unreadNotificationCount
          }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span v-if="notificationList.length < 1" class="dropdown-item">
            No new Notification
          </span>

          <router-link
            :to="{
              name: 'Application Details',
              params: { id: item.applicationId },
            }"
            v-for="(item, index) in notificationList"
            :key="index"
          >
            <span class="dropdown-item">
              {{ item.name + " " + item.message }}
            </span>
            <div class="dropdown-divider"></div>
          </router-link>
        </div>
      </li>

      <li class="nav-item dropdown">
        <!-- <span>Shihab</span> -->
        <span
          class="nav-link d-flex justify-content-center align-items-center"
          data-toggle="dropdown"
        >
          <img
            src="/assets/dist/img/avatar4.png"
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
      userId: localStorage.getItem("loggedInUserId"),
      notificationList: [],
      unreadNotificationCount: 0,
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
            localStorage.removeItem("loggedInUserId");
            localStorage.removeItem("loggedInUserRole");
            localStorage.removeItem("isLoggedInUserManager");
            this.router.push({ name: "Login" });
          } else {
            toastr.info(response.data.message);
          }
        })
        .catch((error) => {
          console.log("error => ", error);
        });
    },
    async getNotifications() {
      await axios
        .get("/api/notification-list/" + this.userId)
        .then((response) => {
          if (response.data.success) {
            response = response.data.data;
            response.forEach((item) => {
              let data = JSON.parse(item.data);
              data["read_at"] = item.read_at;
              this.notificationList.push(data);
            });
            this.unreadNotifications();
          } else {
            toastr.info(response.data.message);
          }
        })
        .catch((error) => {
          console.log("error => ", error);
        });
    },
    async markRead() {
      await axios
        .get("/api/mark-notification-read/" + this.userId)
        .then((response) => {
          if (response.data.success) {
            this.notificationList.map((item) => (item.read_at = Date.now()));
          }
          this.unreadNotifications();
        })
        .catch((error) => {
          console.log("error => ", error);
        });
    },
    unreadNotifications() {
      let result = this.notificationList.filter((item) => item.read_at == null);
      this.unreadNotificationCount = result.length;
    },
  },
  mounted() {
    this.getNotifications();
    Echo.private("App.Models.User." + this.userId).notification(
      (notification) => {
        alert("you have a new notification");
        let data = notification;
        data["read_at"] = null;
        this.notificationList.push(data);
        this.unreadNotifications();
        console.log("new notification arrived", notification);
      }
    );
  },
};
</script>

<style  scoped>
.badge-larger {
  font-size: 15px;
}
.fa-lg {
  font-size: 25px !important;
  line-height: 35px !important;
}
</style>