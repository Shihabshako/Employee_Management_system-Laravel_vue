<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <ContentHeader title="Apply for leave" />
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mx-4">
          <div class="card card-default col-8 offset-2">
            <form @submit.prevent="handleForm()">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 d-flex flex-column" style="gap: 18px">
                    <div class="d-flex flex-column">
                      <label for="">Type of Leave</label>
                      <div class="d-flex align-items-center" style="gap: 30px">
                        <div
                          id="radioButton"
                          class="form-check"
                          v-for="(item, index) in typeOfLeaves"
                          :key="item.id"
                        >
                          <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            :id="'radio' + item.id"
                            :checked="index == 0"
                            :value="item.id"
                            v-model="formData.typeOfLeaves"
                          />
                          <label
                            class="form-check-label"
                            :for="'radio' + item.id"
                          >
                            {{ item.title }}
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="from">From</label>
                        <input
                          type="date"
                          class="form-control"
                          id="from"
                          v-model="formData.from"
                        />
                      </div>
                      <div class="form-group col-6">
                        <label for="to">To</label>
                        <input
                          type="date"
                          class="form-control"
                          id="to"
                          v-model="formData.to"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="subject" class="form-label">Subject</label>
                      <input
                        type="text"
                        class="form-control"
                        id="subject"
                        v-model="formData.subject"
                      />
                    </div>
                    <div class="form-group">
                      <label for="reason">Reason explanation</label>
                      <textarea
                        id="reason"
                        cols="30"
                        rows="5"
                        class="form-control"
                        v-model="formData.details"
                      ></textarea>
                    </div>
                    <div class="d-flex justify-content-end" style="gap: 15px">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
            </form>
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
      typeOfLeaves: {},
      formData: {
        typeOfLeaves: "",
        from: "",
        to: "",
        subject: "",
        details: "",
        userEmail: localStorage.getItem("loggedInUserEmail"),
      },
    };
  },
  async mounted() {
    await axios
      .get("/api/type-of-leaves")
      .then((response) => {
        if (response.data.success) {
          this.typeOfLeaves = response.data.data;
          this.formData.typeOfLeaves = Object.values(this.typeOfLeaves)[0].id;
        }
      })
      .catch((response) => {
        console.log(response);
      });
  },
  methods: {
    async handleForm() {
      await axios
        .post("/api/apply-leaves", this.formData)
        .then((response) => {
          console.log(response);
          if (response.data.success) {
            toastr.success("Applied for leave successful");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  components: { ContentHeader },
};
</script>
<style lang="">
</style>