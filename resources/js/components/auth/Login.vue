<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ 'Login' }}</div>

          <div class="card-body">
            <form @submit.prevent="login">
              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ 'Email Address' }}</label>

                <div class="col-md-6">
                  <input id="email" v-model="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                  <span v-if="errors.email" class="invalid-feedback" role="alert">
                    <strong>{{ errors.email[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ 'Password' }}</label>

                <div class="col-md-6">
                  <input id="password" v-model="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                  <span v-if="errors.password" class="invalid-feedback" role="alert">
                    <strong>{{ errors.password[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input v-model="remember" class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                      {{ 'Remember Me' }}
                    </label>
                  </div>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ 'Login' }}
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
      email: '',
      password: '',
      remember: false,
      errors: {},
    };
  },
  methods: {
    login() {
      axios.post('/login', {
        email: this.email,
        password: this.password,
        remember: this.remember,
      })
          .then(response => {
         this.$router.push("/home");
        console.log(response);
      })
      .catch(error => {
        console.error(error);
        this.errors = error.response.data.errors;
      });
    },
  }
};
</script>
