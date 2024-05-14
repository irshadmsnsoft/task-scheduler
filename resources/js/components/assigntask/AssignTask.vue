<template>
    <div>
        <Navbar />
        <div class="container mt-5">
            <h1>All Assigned Tasks</h1>
            <router-link to="/add-assign-task" class="btn btn-primary float-end"
                >Assign Task</router-link
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
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in tasks.previous"
                                :key="'prev-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.task.title }}</td>
                                <td>{{ item.task.description }}</td>
                                <td>{{ formatDate(item.task.due_date) }}</td>
                                <td>
                                    {{
                                        item.task.priority == "1"
                                            ? "Low"
                                            : item.task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>{{ item.status }}</td>
                                <td>{{ item.comment }}</td>
                                <td>
                                    <router-link
                                        :to="'/edit-assign-task/' + item.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
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
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in tasks.today"
                                :key="'prev-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.task.title }}</td>
                                <td>{{ item.task.description }}</td>
                                <td>{{ formatDate(item.task.due_date) }}</td>
                                <td>
                                    {{
                                        item.task.priority == "1"
                                            ? "Low"
                                            : item.task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>{{ item.status }}</td>
                                <td>{{ item.comment }}</td>
                                <td>
                                    <router-link
                                        :to="'/edit-assign-task/' + item.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
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
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in tasks.next"
                                :key="'prev-' + index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.task.title }}</td>
                                <td>{{ item.task.description }}</td>
                                <td>{{ formatDate(item.task.due_date) }}</td>
                                <td>
                                    {{
                                        item.task.priority == "1"
                                            ? "Low"
                                            : item.task.priority == "2"
                                            ? "Medium"
                                            : "High"
                                    }}
                                </td>
                                <td>{{ item.status }}</td>
                                <td>{{ item.comment }}</td>
                                <td>
                                    <router-link
                                        :to="'/edit-assign-task/' + item.id"
                                        class="btn btn-primary"
                                        >Edit</router-link
                                    >
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
                .get("/get-assign-tasks")
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
    },
    mounted() {
        this.fetchTasks(); // Fetch tasks when component is mounted
    },
};
</script>

<style>
/* Additional styles can be added here */
</style>
