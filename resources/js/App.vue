<template>
  <div>
    <Navbar v-if="!isUrlLogin()" />
    <Sidebar v-if="!isUrlLogin()" />

    <router-view />

    <Footer v-if="!isUrlLogin()" />
  </div>
</template>
<script>
import Navbar from "../js/Components/Navbar.vue";
import Sidebar from "./Components/Sidebar.vue";
import Footer from "./Components/Footer.vue";
import { useRouter } from "vue-router";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

export default {
  data() {
    return {
      message: [],
    };
  },
  methods: {
    isUrlLogin() {
      const router = useRouter();
      let status = false;

      if (
        router.currentRoute.value.name == "Login" ||
        router.currentRoute.value.name == "Not Found"
      ) {
        status = true;
      }

      if (
        !localStorage.getItem("loggedInUserEmail") &&
        router.currentRoute.value.name != "Login"
      ) {
        router.push({ name: "Login" });
      }

      if (
        localStorage.getItem("loggedInUserEmail") &&
        router.currentRoute.value.name == "Login"
      ) {
        router.push({ name: "Home" });
      }

      if (localStorage.getItem("loggedInUserToken")) {
        let access_token = localStorage.getItem("loggedInUserToken");
        window.axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${access_token}`;

        window.Pusher = Pusher;

        window.Echo = new Echo({
          broadcaster: "pusher",
          key: import.meta.env.VITE_PUSHER_APP_KEY,
          cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
          wsHost: window.location.hostname,
          wsPort: 6001,
          forceTLS: false,
          disableStats: true,
          auth: {
            headers: {
              Authorization: "Bearer " + access_token,
            },
          },
        });
      }

      return status;
    },
  },
  components: { Sidebar, Navbar, Footer },
};
</script>
<style lang="">
</style>
