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

export default {
  data() {
    return {
      message: [],
    };
  },
  mounted() {
    Pusher.logToConsole = true;

    var pusher = new Pusher("6479e1dcb3fb77734574", {
      cluster: "ap1",
    });

    var channel = pusher.subscribe("my-channel");
    channel.bind("my-event", function (data) {
      // this.messages.push(JSON.stringify(data));
      alert(JSON.stringify(data));
    });
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
      }

      return status;
    },
  },
  components: { Sidebar, Navbar, Footer },
};
</script>
<style lang="">
</style>
