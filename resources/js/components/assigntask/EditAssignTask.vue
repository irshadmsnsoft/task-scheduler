<template>
    <div>
        <Navbar />
        <div class="container mt-5">
             <div>
                <router-link to="/assign-task" class="btn btn-primary float-end mb-4"
                    >All Assigned Tasks</router-link>
                <h2 class="mb-4">Edit Assigned Task</h2>
            </div>
            <form @submit.prevent="editAssignedTask">
                <div class="form-group">
                    <label for="taskName">Task Name:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="taskName"
                        v-model="task.task_name"
                        required
                        readonly
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="status">Assigned Task Status:</label>
                    <select
                        class="form-control"
                        id="status"
                        v-model="task.status"
                        required
                    >
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="comment">Assign Task Comment:</label>
                    <textarea
                        class="form-control"
                        id="comment"
                        v-model="task.comment"
                        rows="3"
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    Update Assigned Task
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
    name: "EditAssignedTask",
    components: {
        Navbar,
    },
    data() {
        return {
            task: {
                id: "",
                task_name: "",
                status: "",
                comment: "",
            },
        };
    },
    mounted() {
        this.loadAssignedTaskData();
    },
    methods: {
        loadAssignedTaskData() {
            const taskId = this.$route.params.id;
            axios
                .get(`/edit-assign-task/${taskId}`)
                .then((response) => {
                    const data = response.data;
                    this.task = {
                        id: data.id,
                        task_name: data.task.title,
                        status: data.status,
                        comment: data.comment,
                    };
                })
                .catch((error) => {
                    console.error("Error fetching assigned task:", error);
                });
        },
        editAssignedTask() {
            axios
                .post(`/update-assign-task/${this.task.id}`, this.task)
                .then((response) => {
                    toast.success("Task Assigned Updated Successfully", {
                        duration: 5000, // Optional: Specify duration in milliseconds
                    });
                    this.$router.push("/assign-task"); // Redirect or notify success
                })
                .catch((error) => {
                    toast.error(
                        `Error updating assigning task: ${error.message}`,
                        {
                            duration: 5000, // Optional: Specify duration in milliseconds
                        }
                    );
                    console.error("Error updating assigned task:", error);
                });
        },
    },
};
</script>
