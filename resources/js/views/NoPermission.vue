<template lang="">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <ContentHeader title=" " />
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="d-flex flex-column align-items-center justify-content-center " style="margin-top:150px">
                    <h1 ><code>Access Denied</code></h1>
                    <hr  style="margin:auto;width:50%">
                    <h3 >You dont have permission to view this page.</h3>
                    <h3 >🚫🚫🚫🚫</h3>
                    <h6 >Error code : 403 Forbidden</h6>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import ContentHeader from "../Components/ContentHeader.vue";
export default {
  data() {
    return {};
  },
  components: { ContentHeader },
};
</script>
<style scoped>
body {
  background-color: black;
  color: white;
}

h1 {
  color: red !important;
  font-weight: bold !important;
}

h6 {
  color: red !important;
  text-decoration: underline;
}
</style>