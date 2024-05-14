<template>
  <div>
    <Navbar />
    <div class="ms-5 mt-5">
      <h1 class="text-danger">This is the home page</h1>
    </div>
  </div>
</template>

<script>
import Navbar from './includes/Navbar.vue'; // Make sure the path is correct based on your file structure

export default {
    name: "Home",
    components: {
        Navbar // Register the Navbar component
    },

};
</script>


