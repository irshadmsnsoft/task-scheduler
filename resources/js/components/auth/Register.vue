<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form @submit.prevent="register">
              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input v-model="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>

                  <span v-if="errors.name" class="invalid-feedback" role="alert">
                    <strong>{{ errors.name[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                <div class="col-md-6">
                  <input v-model="email" type="email" class="form-control" name="email" required autocomplete="email">

                  <span v-if="errors.email" class="invalid-feedback" role="alert">
                    <strong>{{ errors.email[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                <div class="col-md-6">
                  <input v-model="password" type="password" class="form-control" name="password" required autocomplete="new-password">

                  <span v-if="errors.password" class="invalid-feedback" role="alert">
                    <strong>{{ errors.password[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

                <div class="col-md-6">
                  <input v-model="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                  <span v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                    <strong>{{ errors.password_confirmation[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Register
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: {},
    };
  },
  methods: {
    register() {
      axios.post('/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      })
        .then(response => {
          // Handle successful registration
          console.log(response);
        })
        .catch(error => {
          // Handle error during registration
          console.error(error);
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>