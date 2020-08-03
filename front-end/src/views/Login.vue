<template>
  <div class="home col-5 mx-auto py-5 mt-5">
    <h1 class="text-center">Login</h1>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="email">Email address:</label>
          <input type="email" v-model="form.email" class="form-control" id="email" autocomplete="off"/>
          <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" v-model="form.password" class="form-control" id="password"/>
          <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>
        <button @click.prevent="login" class="btn btn-primary btn-block">Login</button>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../apis/User";
import axios from 'axios'
export default {
  data() {
    return {
      form: {
        email: "",
        password: ""
      },
      errors: []
    };
  },

  methods: {
    login() {
      User.login(this.form)
        .then((resp) => {
          localStorage.setItem("idToken", resp.data.id_token);
          localStorage.setItem("email", resp.data.email);
          axios.defaults.headers.common['Authorization'] = "Bearer " + resp.data.token_access;
          this.$root.$emit("login", true);
          localStorage.setItem("auth", "true");
          this.$router.push({ name: "AllBooks" });
        })
        .catch(error => {
            console.log(error);
          if (error.response.status === 401) {
            this.errors = error.response.data.errors;
             this.$router.push("/").catch(()=>{});

          }
        });
    }
  }
};
</script>
