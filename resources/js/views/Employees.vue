<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <ContentHeader title="Employees" />
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
              <h3 class="card-title">All employee details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in employeeList" :key="item.id">
                    <td
                      class="
                        text-right
                        d-flex
                        justify-content-around
                        align-items-center
                      "
                    >
                      <span class="text-lg">{{ item.id }}</span>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.dept_name }}</td>
                    <td>{{ item.designation }}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <router-link
                          :to="{
                            name: 'Employee Profile',
                            params: { id: item.id },
                          }"
                          class="btn btn-info"
                        >
                          <i class="fas fa-eye"></i>
                        </router-link>
                        <button
                          class="btn btn-danger"
                          @click="deleteItem(item.id)"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <!-- table data to show -->
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
      employeeList: {},
    };
  },
  mounted() {
    this.getEmployees();
  },
  methods: {
    async getEmployees() {
      await axios
        .get("/api/employees")
        .then((response) => {
          this.employeeList = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });

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
    async deleteItem(id) {
      if (!confirm("Are you sure?")) {
        return;
      }
      await axios
        .delete("/api/employees/" + id)
        .then((response) => {
          if (response.data.success) {
            toastr.success("User deleted successfully");
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
      this.getEmployees();
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>