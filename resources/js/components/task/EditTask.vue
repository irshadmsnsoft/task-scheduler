<template>
    <div>
        <Navbar />
        <div class="container mt-5">
             <div>
                <router-link to="/task" class="btn btn-primary float-end mb-4"
                    >All Tasks</router-link>
                <h2 class="mb-4">Edit Task</h2>
            </div>
            <form @submit.prevent="editTask">
                <div class="form-group">
                    <label for="title">Task Title:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        v-model="task.title"
                        required
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="description">Task Description:</label>
                    <textarea
                        class="form-control"
                        id="description"
                        v-model="task.description"
                        rows="4"
                        required
                    ></textarea>
                </div>
                <div class="form-group mt-2">
                    <label for="due_date">Task Due Date:</label>
                    <input
                        type="date"
                        class="form-control"
                        id="due_date"
                        v-model="task.due_date"
                        required
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="priority">Task Priority:</label>
                    <select
                        class="form-control"
                        id="priority"
                        v-model="task.priority"
                        required
                    >
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    Update Task
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
    name: "Task",
    components: {
        Navbar,
    },
    data() {
        return {
            task: {
                id: "",
                title: "",
                description: "",
                due_date: "",
                priority: "",
            },
        };
    },
    mounted() {
        this.loadTaskData();
    },
    methods: {
        loadTaskData() {
             const taskId = this.$route.params.id;
    axios
        .get(`/edit-task/${taskId}`)
        .then((response) => {
            this.task.id = response.data.id;
            this.task.title = response.data.title;
            this.task.description = response.data.description;
            this.task.due_date = new Date(response.data.due_date).toISOString().split('T')[0];
            this.task.priority = response.data.priority;
        })
        .catch((error) => {
            console.error("Error fetching task:", error);
        });
        },
        editTask() {
            axios
                .post(`/update-task/${this.task.id}`, this.task)
                .then((response) => {
                     toast.success("Task Updated successfully", {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    // Handle successful update
                    this.$router.push("/task"); // Redirect to tasks page or show success message
                })
                .catch((error) => {
                     toast.error(`Error updating task: ${error.message}`, {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    console.error("Error updating task:", error);
                });
        },
    },
};
</script>
