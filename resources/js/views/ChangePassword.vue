<template lang="">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-center align-items-center" style="height:80vh">
                    <div class="col-md-6">
                        <span class="anchor" id="formChangePassword"></span>
                        <!-- form card change password -->
                        <div class="card card-outline-secondary">
                            <div class="card-header">
                                <h3 class="mb-0">Change Password</h3>
                            </div>
                            <div class="card-body">
                                <form class="form" role="form" autocomplete="off" @submit.prevent="handleForm()">
                                    <div class="form-group" >
                                        <label for="inputPasswordOld">Current Password</label>
                                        <input type="password" class="form-control" required="" v-model="formData.currentPassword">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew">New Password</label>
                                        <input type="password" class="form-control" required="" v-model="formData.newPassword"  @focusout="checkPasswordValidity" >
                                        <span class="form-text small text-muted">
                                            The password must be 8-20 characters
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNewVerify">Verify</label>
                                        <input type="password" class="form-control"  @focusout="matchPassword" required="" v-model="formData.confirmPassword">
                                        <span class="form-text small text-muted">
                                            To confirm, type the new password again.
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg float-right" :disabled="submitButtonStatus">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /form card change password -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import { useRouter } from "vue-router";

export default {
  data() {
    return {
      formData: {
        email: localStorage.getItem("loggedInUserEmail"),
        currentPassword: "",
        newPassword: "",
        confirmPassword: "",
      },
      router: useRouter(),
      submitButtonStatus: true,
      passwordMatch: false,
      newPasswordValidation: false,
    };
  },
  methods: {
    async handleForm() {
      await axios
        .post("/api/change-password", this.formData)
        .then((response) => {
          console.log(response.data);
          if (response.data.success) {
            toastr.success("Password Has been updated, please login again");
            localStorage.removeItem("loggedInUserEmail");
            localStorage.removeItem("loggedInUserToken");
            this.router.push({ name: "Home" });
          } else {
            toastr.error(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    matchPassword() {
      if (this.formData.newPassword != this.formData.confirmPassword) {
        this.passwordMatch = false;
        toastr.warning("Password should be matched");
      } else {
        this.passwordMatch = true;
        if (this.passwordMatch && this.newPasswordValidation) {
          this.submitButtonStatus = false;
        }
      }
    },
    checkPasswordValidity() {
      if (this.formData.newPassword.length < 8) {
        toastr.warning("The password must be 8-20 characters");
      } else {
        this.newPasswordValidation = true;
        if (this.passwordMatch && this.newPasswordValidation) {
          this.submitButtonStatus = false;
        }
      }
    },
  },
};
</script>
<style lang="">
</style>