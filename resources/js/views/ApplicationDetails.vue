<template lang="">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <ContentHeader title="Application Details" />
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-default col-8 offset-2 p-5">
                        <p>Applicant Name : {{ details.name }} </p>
                        <p>Subject : {{ details.subject }}</p>
                        <p>Deration : <strong>{{ details.from }}</strong> to <strong>{{ details.to }}</strong></p>
                        <p>{{ details.details }}</p>
                        <p></p>
                        <div v-if="checkPermission()" class="row d-flex justify-content-end" style="gap : 10px">
                            <button class="btn btn-danger">Deny</button>
                            <button class="btn btn-success">Approve</button>
                        </div>
                    </div>
                    
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import { useRoute } from "vue-router";
import ContentHeader from "../Components/ContentHeader.vue";
export default {
  data() {
    return {
      router: useRoute(),
      details: {},
    };
  },
  mounted() {
    this.getApplicationDetails();
  },
  methods: {
    async getApplicationDetails() {
      await axios
        .get("/api/apply-leaves/" + this.router.params.id)
        .then((response) => {
          this.details = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    checkPermission() {
      let role = localStorage.getItem("loggedInUserRole");
      let isManager =
        localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;
      if (role == "HR" || role == "Admin" || isManager) {
        return true;
      }
      return false;
    },
    approveApplications() {
      let role = localStorage.getItem("loggedInUserRole");
      let isManager =
        localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;

      // if (role == "Engineers" && isManager) {

      // }
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>