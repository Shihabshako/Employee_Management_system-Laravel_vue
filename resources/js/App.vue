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

    var pusher = new Pusher("b2bc2a2ebfc6eadc1101", {
      cluster: "ap2",
    });

    var channel = pusher.subscribe("my-channel");
    channel.bind("my-event", function (data) {
      this.messages.push(JSON.stringify(data));
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

      if (localStorage.getItem("loggedInUserToken")) {
        let access_token = localStorage.getItem("loggedInUserToken");
        window.axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${access_token}`;
      }

      return status;
    },
    listenForChanges() {
      //   Echo.channel("applyLeaveNotification").listen(
      //     "NotificationPublished",
      //     (post) => {
      //       if (!("Notification" in window)) {
      //         alert("Web Notification is not supported");
      //         return;
      //       }
      //       Notification.requestPermission((permission) => {
      //         let notification = new Notification("Awesome Website", {
      //           body: post.message,
      //           icon: "https://pusher.com/static_logos/320x320.png", // optional image url
      //         });
      //         // link to page on clicking the notification
      //         notification.onclick = () => {
      //           window.open(window.location.href);
      //         };
      //       });
      //     }
      //   );
      // },
    },
  },
  components: { Sidebar, Navbar, Footer },
};
</script>
<style lang="">
</style>
