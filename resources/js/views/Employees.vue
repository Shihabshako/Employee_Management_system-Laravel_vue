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
                    <th style="width: 80px">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Manager</th>
                    <th>Address</th>
                    <th>Social</th>
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
                      <div class="btn-group btn-group-sm">
                        <button
                          class="btn btn-info"
                          data-toggle="modal"
                          data-target="#modal-default"
                          @click="editItem(item.id)"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-danger"
                          @click="deleteItem(item.id)"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.dept_name }}</td>
                    <td>{{ item.designation }}</td>
                    <td>
                      <p
                        v-if="item.manager"
                        class="p-1 bg-success rounded px-2 m-0"
                      >
                        {{ item.manager }}
                      </p>
                      <p v-else class="p-1 bg-danger rounded px-2 m-0">
                        Not Assigned
                      </p>
                    </td>
                    <td>{{ item.address }}</td>
                    <td>
                      <div
                        class="d-flex flex-wrap align-items-start"
                        style="gap: 10px"
                      >
                        <a :href="'//' + item.website" target="_blank"
                          ><i class="fas fa-globe"></i
                        ></a>
                        <a :href="'//' + item.github" target="_blank"
                          ><i class="fab fa-github"></i
                        ></a>
                        <a :href="'//' + item.twitter" target="_blank"
                          ><i class="fab fa-twitter"></i
                        ></a>
                        <a :href="'//' + item.linkedin" target="_blank"
                          ><i class="fab fa-linkedin"></i
                        ></a>
                        <a :href="'//' + item.facebook" target="_blank"
                          ><i class="fab fa-facebook"></i
                        ></a>
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

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Employee</h4>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="handleForm()">
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-4 form-group">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    placeholder="John Doe"
                    aria-describedby="helpId"
                    v-model="formData.name"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="email">Email</label>
                  <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="john@gmail.com"
                    aria-describedby="helpId"
                    v-model="formData.email"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="phone">Phone</label>
                  <input
                    type="text"
                    id="phone"
                    class="form-control"
                    placeholder="01xxxxxxxxxx"
                    aria-describedby="helpId"
                    v-model="formData.phone"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="address">Address</label>
                  <input
                    type="text"
                    id="address"
                    class="form-control"
                    placeholder="Resident address"
                    aria-describedby="helpId"
                    v-model="formData.address"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="website">Website</label>
                  <input
                    type="text"
                    id="website"
                    class="form-control"
                    placeholder="Enter url"
                    aria-describedby="helpId"
                    v-model="formData.website"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="github">Github</label>
                  <input
                    type="text"
                    id="github"
                    class="form-control"
                    placeholder="Enter url"
                    aria-describedby="helpId"
                    v-model="formData.github"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="twitter">Twitter</label>
                  <input
                    type="text"
                    id="twitter"
                    class="form-control"
                    placeholder="Enter url"
                    aria-describedby="helpId"
                    v-model="formData.twitter"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="linkedin">LinkedIn</label>
                  <input
                    type="text"
                    id="linkedin"
                    class="form-control"
                    placeholder="Enter url"
                    aria-describedby="helpId"
                    v-model="formData.linkedin"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="facebook">Facebook</label>
                  <input
                    type="text"
                    id="facebook"
                    class="form-control"
                    placeholder="Enter url"
                    aria-describedby="helpId"
                    v-model="formData.facebook"
                  />
                </div>
                <div class="col-4 form-group">
                  <label for="department">Department</label>
                  <select class="form-control" v-model="formData.dept_id">
                    <option value="0" selected disabled>
                      Assign Department
                    </option>
                    <option
                      v-for="item in departments"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.dept_name }}
                    </option>
                  </select>
                </div>
                <div class="col-4 form-group">
                  <label for="designation">Designation</label>
                  <select
                    class="form-control"
                    v-model="formData.designation_id"
                  >
                    <option value="0" selected disabled>
                      Assign Designation
                    </option>
                    <option
                      v-for="item in designations"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.title }}
                    </option>
                  </select>
                </div>
                <div class="col-4 form-group">
                  <label for="role">Role</label>
                  <select class="form-control" v-model="formData.role_id">
                    <option value="0" selected disabled>Assign Role</option>
                    <option
                      v-for="item in roles"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.role_name }}
                    </option>
                  </select>
                </div>
                <div class="col-4 form-group">
                  <label for="role">Manager</label>
                  <select class="form-control" v-model="formData.manager_id">
                    <option value="0" selected disabled>Assign Manager</option>
                    <option
                      v-for="item in managers"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</template>
<script>
import ContentHeader from "../Components/ContentHeader.vue";
export default {
  data() {
    return {
      employeeList: {},
      roles: {},
      designations: {},
      departments: {},
      managers: {},
      formData: {
        name: "",
        email: "",
        phone: "",
        address: "",
        website: "",
        github: "",
        twitter: "",
        linkedin: "",
        facebook: "",
        role_id: 0,
        designation_id: 0,
        dept_id: 0,
        manager_id: 0,
      },
    };
  },
  mounted() {
    this.getEmployees();
    this.getDropdownValues();
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
    async getDropdownValues() {
      await axios
        .get("/api/dropdown-values/")
        .then((response) => {
          if (response.data.success) {
            this.roles = response.data.data.roles;
            this.designations = response.data.data.designations;
            this.departments = response.data.data.departments;
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async editItem(id) {
      this.managers = this.employeeList.filter((item) => item.id != id);
      await axios
        .get("/api/employees/" + id)
        .then((response) => {
          if (response.data.success) {
            this.formData.id = id;
            this.formData.name = response.data.data.name;
            this.formData.email = response.data.data.email;
            this.formData.phone = response.data.data.phone;
            this.formData.address = response.data.data.address;
            this.formData.website = response.data.data.website;
            this.formData.github = response.data.data.github;
            this.formData.twitter = response.data.data.twitter;
            this.formData.linkedin = response.data.data.linkedin;
            this.formData.facebook = response.data.data.facebook;
            this.formData.role_id = response.data.data.role_id;
            this.formData.designation_id = response.data.data.designation_id;
            this.formData.dept_id = response.data.data.dept_id;
            this.formData.manager_id = response.data.data.manager_id ?? 0;
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async handleForm() {
      await axios
        .put("/api/update-user/" + this.formData.id, this.formData)
        .then((response) => {
          if (response.data.success) {
            localStorage["loggedInUserEmail"] = this.formData.email;
            toastr.success("Data updated successfully");
            this.getEmployees();
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
      $("#modal-default").modal("toggle");
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>