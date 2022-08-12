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
                        <p>Type of Leave : {{ details.title  }}</p>
                        <p>Deration : <strong>{{ details.from }}</strong> to <strong>{{ details.to }}</strong></p>
                        <p>Manager Response : 
                          <span
                            v-if="details.approved_by_manager == 0"
                            class="text-warning font-weight-bold"
                            >Reviewing</span
                          >
                          <span
                            v-else-if="details.approved_by_manager == 1"
                            class="text-success font-weight-bold"
                            >Approved</span
                          >
                          <span v-else class="text-danger font-weight-bold"
                            >Declined</span
                          >  
                        </p>
                        <p>Administration Respnose : 
                          <span
                            v-if="details.approved_by_administration == 0"
                            class="text-warning font-weight-bold"
                            >Reviewing</span
                          >
                          <span
                            v-else-if="details.approved_by_administration == 1"
                            class="text-success font-weight-bold"
                            >Approved</span
                          >
                          <span v-else class="text-danger font-weight-bold"
                            >Declined</span
                          >  
                        </p>
                        <p>{{ details.details }}</p>
                        <p></p>
                        <div v-if="checkPermission() " class="row d-flex justify-content-end" style="gap : 10px">
                            <button class="btn btn-danger"  @click="declineApplications()"  >Decline</button>
                            <button class="btn btn-success" @click="approveApplications()"  >Approve</button>
                        </div>
                    </div>
                    
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import { useRoute, useRouter } from "vue-router";
import ContentHeader from "../Components/ContentHeader.vue";
export default {
  data() {
    return {
      router: useRouter(),
      route: useRoute(),
      details: {},
    };
  },
  mounted() {
    this.getApplicationDetails();
  },
  methods: {
    async getApplicationDetails() {
      await axios
        .get("/api/apply-leaves/" + this.route.params.id)
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
    async approveApplications() {
      let role = localStorage.getItem("loggedInUserRole");
      let isManager =
        localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;

      if (role == "Engineers" && isManager) {
        await axios
          .get("/api/approve-application-by-manager/" + this.route.params.id)
          .then((response) => {
            console.log(response);
            if (response.data.success) {
              toastr.success("Application has been approved");
              this.router.push({ name: "Leave Status" });
            } else {
              toastr.error(response.data.message);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }

      if (role == "HR" || role == "Admin") {
        await axios
          .get(
            "/api/approve-application-by-administration/" + this.route.params.id
          )
          .then((response) => {
            if (response.data.success) {
              toastr.success("Application has been approved");
              this.router.push({ name: "Leave Status" });
            } else {
              toastr.error(response.data.message);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    async declineApplications() {
      let role = localStorage.getItem("loggedInUserRole");
      let isManager =
        localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;

      if (role == "Engineers" && isManager) {
        await axios
          .get("/api/decline-application-by-manager/" + this.route.params.id)
          .then((response) => {
            if (response.data.success) {
              toastr.success("Application has been declined");
              this.router.push({ name: "Leave Status" });
            } else {
              toastr.error(response.data.message);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }

      if (role == "HR" || role == "Admin") {
        await axios
          .get(
            "/api/decline-application-by-administration/" + this.route.params.id
          )
          .then((response) => {
            if (response.data.success) {
              toastr.success("Application has been approved");
              this.router.push({ name: "Leave Status" });
            } else {
              toastr.error(response.data.message);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>