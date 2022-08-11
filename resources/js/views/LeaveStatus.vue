<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <ContentHeader title="Leave status" />
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- info cards -->
        <div class="row mx-4">
          <div class="card card-default col-12">
            <div class="card-header">
              <h3 class="card-title">Employee information</h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-tool"
                  data-card-widget="collapse"
                >
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"
                      ><i class="far fa-envelope"></i
                    ></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Messages</span>
                      <span class="info-box-number">1,410</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"
                      ><i class="far fa-flag"></i
                    ></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Bookmarks</span>
                      <span class="info-box-number">410</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-warning"
                      ><i class="far fa-copy"></i
                    ></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Uploads</span>
                      <span class="info-box-number">13,648</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"
                      ><i class="far fa-star"></i
                    ></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Likes</span>
                      <span class="info-box-number">93,139</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <div class="row mx-4">
          <div class="card col-12">
            <div class="card-header">
              <h3 class="card-title">All Leave Applications</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Manager Approval</th>
                    <th>HR Approval</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in applicationList" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.subject }}</td>
                    <td>
                      <span
                        v-if="item.approved_by_manager == 0"
                        class="badge-warning p-1 rounded"
                        >Reviewing</span
                      >
                      <span
                        v-else-if="item.approved_by_manager == 1"
                        class="badge-success p-1 rounded"
                        >Approved</span
                      >
                      <span v-else class="badge-danger p-1 rounded"
                        >Declined</span
                      >
                    </td>
                    <td>
                      <span
                        v-if="item.approved_by_administration == 0"
                        class="badge-warning p-1 rounded"
                        >Reviewing</span
                      >
                      <span
                        v-else-if="item.approved_by_administration == 1"
                        class="badge-success p-1 rounded"
                        >Approved</span
                      >
                      <span v-else class="badge-danger p-1 rounded"
                        >Declined</span
                      >
                    </td>

                    <td>
                      <router-link
                        :to="{
                          name: 'Application Details',
                          params: { id: item.id },
                        }"
                        ><i class="fas fa-eye"></i
                      ></router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
import ContentHeader from "../Components/ContentHeader.vue";
export default {
  data() {
    return {
      applicationList: {},
    };
  },
  mounted() {
    this.getApplications();
  },
  methods: {
    async getApplications() {
      let role = localStorage.getItem("loggedInUserRole");
      let email = localStorage.getItem("loggedInUserEmail");
      let isManager =
        localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;

      if (role == "Engineers" && !isManager) {
        await axios
          .get("/api/apply-leaves")
          .then((response) => {
            response = response.data.data;
            response = response.filter((item) => item.email == email);
            this.applicationList = response;
          })
          .catch((error) => {
            console.log(error);
          });
      }

      if (role == "Engineers" && isManager) {
        await axios
          .post("/api/apply-leaves-per-manager", { email: email })
          .then((response) => {
            this.applicationList = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }

      if (role == "HR" || role == "Admin") {
        await axios
          .get("/api/apply-leaves")
          .then((response) => {
            this.applicationList = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }

      if (!$.fn.dataTable.isDataTable("#example1")) {
        $("#example1")
          .DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
          })
          .buttons()
          .container()
          .appendTo("#example1_wrapper .col-md-6:eq(0)");
      }
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>