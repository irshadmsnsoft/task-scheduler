<template>
    <div>
        <Navbar />
        <div class="container mt-5">
            <div>
                <router-link to="/task" class="btn btn-primary float-end mb-4"
                    >All Tasks</router-link>
                <h2 class="mb-4">Create New Task</h2>
            </div>
            <form @submit.prevent="addTask">
                <div class="form-group">
                    <label for="title">Task Title:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        v-model="newTask.title"
                        required
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="description">Task Description:</label>
                    <textarea
                        class="form-control"
                        id="description"
                        v-model="newTask.description"
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
                        v-model="newTask.due_date"
                        required
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="priority">Task Priority:</label>
                    <select
                        class="form-control"
                        id="priority"
                        v-model="newTask.priority"
                        required
                    >
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    Add Task
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
            newTask: {
                title: "",
                description: "",
                due_date: "",
                priority: "1",
            },
        };
    },
    methods: {
        addTask() {
            axios
                .post("/add-task", this.newTask)
                .then((response) => {
                    // Task added successfully, close the modal and refresh tasks
                    toast.success("Task added successfully", {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    // this.$router.push("/task");
                })
                .catch((error) => {
                    toast.error(`Error adding task: ${error.message}`, {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    console.error("Error adding task:", error);
                });
        },
    },
};
</script>
