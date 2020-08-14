<template>
  <div class="home col-5 mx-auto py-5 mt-5">
    <h1 class="text-center">Register</h1>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" v-model="form.name" class="form-control" id="name"/>
          <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
        </div>
        <div class="form-group">
          <label for="email">Email address:</label>
          <input type="email" v-model="form.email" class="form-control" id="email"/>
          <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>
        <div class="form-group">
          <label for="role">Roles:</label>
          <select v-model="form.role" class="form-control" id="role">
            <option value="">----</option>
            <option v-for="role in roles" :value="role.id">
              {{ role.name }}
            </option>
          </select>
          <span class="text-danger" v-if="errors.role">{{ errors.role[0] }}</span>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" v-model="form.password" class="form-control" id="password"/>
          <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirm Password:</label>
          <input type="password" v-model="form.password_confirmation" class="form-control" id="password_confirmation"/>
          <span class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</span>
        </div>
        <button type="submit" @click.prevent="register" class="btn btn-primary btn-block">Register</button>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../../apis/User";
import axios from "axios";

export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        role:"",
        password: "",
        password_confirmation: ""
      },
      roles:[],
      errors: []
    };
  },
  created() {
    axios.get('http://localhost:8084/api/list-roles')
        .then(response => {
          console.log(response.data);
          this.roles = response.data
        })
  },
  methods: {
    register() {
      User.register(this.form)
          .then(() => {
            this.$router.push({name: "Login"});
          })
          .catch(error => {
            if (error.response.status === 422) {
              console.log(error.response.data.errors);
              this.errors = error.response.data.errors;
            }
          });
    }
  }
};
</script>
