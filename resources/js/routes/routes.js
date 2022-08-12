import { createRouter, createWebHistory, useRouter } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Employees from "../views/Employees.vue";
import Login from "../views/Login.vue";
import NotFound from "../Components/NotFound.vue";
import Profile from "../views/Profile.vue";
import ChangePassword from "../views/ChangePassword.vue";
import EmployeeProfile from "../views/EmployeeProfile.vue";
import ApplyLeave from "../views/ApplyLeave.vue";
import ApproveLeave from "../views/ApproveLeave.vue";
import LeaveStatus from "../views/LeaveStatus.vue";
import NoPermission from "../views/NoPermission.vue";
import ApplicationDetails from "../views/ApplicationDetails.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Dashboard,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
    },
    {
        path: "/employees",
        name: "Employees",
        component: Employees,
        beforeEnter: (to, from, next) => {
            let role = localStorage.getItem("loggedInUserRole");

            if (role == "HR" || role == "Admin") {
                next();
            } else {
                next({ name: "No permission" });
            }
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
    },
    {
        path: "/change-password",
        name: "Change Password",
        component: ChangePassword,
    },
    {
        path: "/employee-profile/:id",
        name: "Employee Profile",
        component: EmployeeProfile,
        props: true,
        beforeEnter: (to, from, next) => {
            let role = localStorage.getItem("loggedInUserRole");
            if (role == "HR" || role == "Admin") {
                next();
            } else {
                next({ name: "No permission" });
            }
        },
    },
    {
        path: "/application-details/:id",
        name: "Application Details",
        component: ApplicationDetails,
    },
    {
        path: "/apply-leave",
        name: "Apply Leave",
        component: ApplyLeave,
    },
    {
        path: "/leave-status",
        name: "Leave Status",
        component: LeaveStatus,
    },
    {
        path: "/no-permission",
        name: "No permission",
        component: NoPermission,
    },

    //catchall 404
    {
        path: "/:catchall(.*)",
        name: "Not Found",
        component: NotFound,
    },
];

const router = createRouter({
    mode: "history",
    base: "./",
    history: createWebHistory("/"),
    routes,
});

export default router;
