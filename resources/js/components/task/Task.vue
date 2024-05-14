<template>
    <div>
        <Navbar />
        <div class="container mt-5">
            <h1>All Tasks</h1>
            <router-link to="/add-task" class="btn btn-primary float-end mb-2"
                >Add Task</router-link
            >
            <!-- Task Tabs and Content -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ active: activeTab === 'previous' }"
                        href="#"
                        @click="activeTab = 'previous'"
                        >Previous Tasks</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ active: activeTab === 'today' }"
                        href="#"
                        @click="activeTab = 'today'"
                        >Today's Tasks</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ active: activeTab === 'next' }"
                        href="#"
                        @click="activeTab = 'next'"
                        >Next Tasks</a
                    >
                </li>
            </ul>

            <!-- Task Content -->
            <div class="tab-content mt-3">
                <div v-if="activeTab === 'previous'">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(task, index) in tasks.previous"
                                :key="'prev-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ task.title }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ formatDate(task.due_date) }}</td>
                                <td>
                                    {{
                                        task.priority == "1"
                                            ? "Low"
                                            : task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>
                                    <router-link
                                        :to="'/edit-task/' + task.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="btn btn-danger ms-1"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="activeTab === 'today'">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(task, index) in tasks.today"
                                :key="'today-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ task.title }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ formatDate(task.due_date) }}</td>
                                <td>
                                    {{
                                        task.priority == "1"
                                            ? "Low"
                                            : task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>
                                    <router-link
                                        :to="'/edit-task/' + task.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="btn btn-danger ms-1"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="activeTab === 'next'">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(task, index) in tasks.next"
                                :key="'next-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ task.title }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ formatDate(task.due_date) }}</td>
                                <td>
                                    {{
                                        task.priority == "1"
                                            ? "Low"
                                            : task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>
                                    <router-link
                                        :to="'/edit-task/' + task.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="btn btn-danger ms-1"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
            activeTab: "today",
            tasks: {
                previous: [],
                today: [],
                next: [],
            },
            newTask: {
                title: "",
                description: "",
                due_date: "",
                priority: "1",
            },
        };
    },
    methods: {
        fetchTasks() {
            axios
                .get("/get-tasks")
                .then((response) => {
                    console.log("response", response.data);
                    this.tasks.previous = response.data.previous;
                    this.tasks.today = response.data.today;
                    this.tasks.next = response.data.next;
                })
                .catch((error) => {
                    console.error("Error fetching tasks:", error);
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, "0"); // Get day and pad with leading zero if necessary
            const month = (date.getMonth() + 1).toString().padStart(2, "0"); // Get month (zero-based index) and pad with leading zero if necessary
            const year = date.getFullYear().toString(); // Get full year
            return `${day}/${month}/${year}`;
        },
        deleteTask(taskId) {
            axios
                .delete(`/delete-task/${taskId}`)
                .then((response) => {
                    toast.success("Task Deleted Successfully", {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    this.fetchTasks();
                })
                .catch((error) => {
                    toast.error(`Error deleting task: ${error.message}`, {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    console.error("Error deleting task:", error);
                });
        },
    },
    mounted() {
        this.fetchTasks(); // Fetch tasks when component is mounted
    },
};
</script>

<style>
/* Additional styles can be added here */
</style>
