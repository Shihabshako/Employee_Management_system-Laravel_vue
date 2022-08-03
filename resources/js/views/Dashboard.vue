<template lang="">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <ContentHeader title="Dashboard" />
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <InfoCard title="Employees" :value="details.employees" iconClass="ion ion-person-add" cardColor="info" />
                    <InfoCard title="Roles" :value="details.roles" iconClass="ion ion-stats-bars" cardColor="danger" />
                    <InfoCard title="Designations" :value="details.designations" iconClass="ion ion-bag"  cardColor="success"/>
                    <InfoCard title="Departments" :value="details.departments" iconClass="ion ion-pie-graph" cardColor="warning" />
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import ContentHeader from "../Components/ContentHeader.vue";
import InfoCard from "../Components/InfoCard.vue";
export default {
  data() {
    return {
      details: {},
      loading: true,
    };
  },
  async mounted() {
    await axios
      .get("/api/cards-count")
      .then((response) => {
        this.details = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  components: { ContentHeader, InfoCard },
};
</script>
<style lang="">
</style>