<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Task Schedule</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link to="/home" class="nav-link">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/task" class="nav-link">Tasks</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/assign-task" class="nav-link"
                        >Assign Tasks</router-link
                    >
                </li>
                <li class="nav-item">
                    <button class="btn btn-danger nav-link" @click="logout">
                        Logout
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    name: "Navbar",
    methods: {
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    console.log("Logged out:", response);
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.error("Logout failed:", error);
                });
        },
    },
};
</script>

<style>
/* Add any specific styles for your navbar here */
</style>
