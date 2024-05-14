<template>
    <div>
        <Navbar />
        <div class="container mt-5">
            <div>
                <router-link to="/assign-task" class="btn btn-primary float-end mb-4"
                    >All Assigned Tasks</router-link>
                <h2 class="mb-4">Assign Task to User</h2>
            </div>
            <form @submit.prevent="assignTask">
                <div class="form-group">
                    <label for="user_id">Select User:</label>
                    <select
                        class="form-control"
                        id="user_id"
                        v-model="assign.user_id"
                        required
                    >
                        <option
                            v-for="user in users"
                            :value="user.id"
                            :key="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="task_id">Select Task:</label>
                    <select
                        class="form-control"
                        id="task_id"
                        v-model="assign.task_id"
                        required
                    >
                        <option
                            v-for="task in tasks"
                            :value="task.id"
                            :key="task.id"
                        >
                            {{ task.title }}
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    Assign Task
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import Navbar from "../includes/Navbar.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
    name: "AssignTask",
    components: {
        Navbar,
    },
    data() {
        return {
            assign: {
                user_id: "",
                task_id: "",
            },
            users: [], // This should be fetched from an API
            tasks: [], // This should be fetched from an API
        };
    },
    created() {
        this.fetchUsers();
        this.fetchTasks();
    },
    methods: {
        fetchUsers() {
            // Example API call to fetch users
            axios.get("/users").then((response) => {
                this.users = response.data;
            });
        },
        fetchTasks() {
            // Example API call to fetch tasks
            axios.get("/tasks").then((response) => {
                this.tasks = response.data;
            });
        },
        assignTask() {
            axios
                .post("/add-assign-task", this.assign)
                .then((response) => {
                    toast.success("Task Assigned successfully", {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    // this.$router.push("/assign-task");
                })
                .catch((error) => {
                    toast.error(`Error assigning task: ${error.message}`, {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    console.error("Error assigning task:", error);
                });
        },
    },
};
</script>
