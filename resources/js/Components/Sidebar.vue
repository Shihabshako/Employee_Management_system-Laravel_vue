<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link :to="{ name: 'Home' }" class="brand-link">
      <img
        src="/assets/dist/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">Enkaizen</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
          <li class="nav-item" v-if="menuPermission.dashboard">
            <router-link :to="{ name: 'Dashboard' }" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt mr-2"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="menuPermission.employees">
            <router-link :to="{ name: 'Employees' }" class="nav-link">
              <i class="nav-icon fas fa-users mr-2"></i>
              <p>Employees</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="menuPermission.applyLeave">
            <router-link :to="{ name: 'Apply Leave' }" class="nav-link">
              <i class="nav-icon fas fa-door-open mr-2"></i>
              <p>Apply for Leave</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="menuPermission.leaveStatus">
            <router-link :to="{ name: 'Leave Status' }" class="nav-link">
              <i class="nav-icon fas fa-list-alt mr-2"></i>
              <p>Leave Status</p>
            </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
export default {
  data() {
    return {
      menuPermission: {
        dashboard: true,
        employees: false,
        applyLeave: false,
        leaveStatus: false,
      },
    };
  },
  mounted() {
    let role = localStorage.getItem("loggedInUserRole");
    let isManager =
      localStorage.getItem("isLoggedInUserManager") == "true" ? true : false;

    if (role == "HR" || role == "Admin") {
      this.menuPermission.dashboard = true;
      this.menuPermission.employees = true;
      this.menuPermission.applyLeave = false;
      this.menuPermission.leaveStatus = true;
    }
    if (role == "Engineers") {
      this.menuPermission.dashboard = true;
      this.menuPermission.employees = false;
      this.menuPermission.applyLeave = true;
      this.menuPermission.leaveStatus = true;
    }
  },
};
</script>
<style scoped>
</style>