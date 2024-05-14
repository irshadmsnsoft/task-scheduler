// router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import Login from "../components/auth/Login.vue";
import Register from "../components/auth/Register.vue";
import Task from "../components/task/Task.vue";
import AddTask from "../components/task/AddTask.vue";
import EditTask from "../components/task/EditTask.vue";
import AssignTask from "../components/assigntask/AssignTask.vue";
import AddAssignTask from "../components/assigntask/AddAssignTask.vue";
import EditAssignTask from "../components/assigntask/EditAssignTask.vue";

const routes = [
    {
        path: "/home",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/task",
        name: "Task",
        component: Task,
    },
    {
        path: "/add-task",
        name: "AddTask",
        component: AddTask,
    },
    {
        path: "/edit-task/:id",
        name: "EditTask",
        component: EditTask,
    },
    {
        path: "/assign-task",
        name: "AssignTask",
        component: AssignTask,
    },
    {
        path: "/add-assign-task",
        name: "AddAssignTask",
        component: AddAssignTask,
    },
    {
        path: "/edit-assign-task/:id",
        name: "EditAssignTask",
        component: EditAssignTask,
    },
    // Add more routes as needed
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
