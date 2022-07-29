<template lang="">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link :to="{name : 'Home'}" class="brand-link">
            <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Enkaizen</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link  :to="{name: 'Dashboard'}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link  :to="{name : 'Employees'}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p> Employees </p>
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
export default {};
</script>
<style lang="">
</style>