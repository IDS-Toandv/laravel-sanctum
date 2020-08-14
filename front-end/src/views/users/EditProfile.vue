<template>
  <div class="home col-7 mx-auto py-3 mt-3">
    <h3 class="text-center">Edit Profile</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="editProfile">
          <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" v-model="profile.name">
            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
          </div>
          <div class="form-group">
            <label>Email address:</label>
            <input type="email" class="form-control" v-model="profile.email">
            <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
          </div>
          <div class="form-group">
            <label>Roles:</label>
            <select class="form-control" v-model="profile.role_id">
              <option value="">----</option>
              <option v-for="role in roles" :value="role.id">
                {{ role.name }}
              </option>
            </select>
            <span class="text-danger" v-if="errors.role">{{ errors.role[0] }}</span>
          </div>
          <div class="form-group">
            <label>Old Password:</label>
            <input type="password" class="form-control" v-model="profile.password_old">
            <span class="text-danger" v-if="errors.password_old">{{ errors.password_old[0] }}</span>
          </div>
          <div class="form-group">
            <label>New Password:</label>
            <input type="password" class="form-control" v-model="profile.password_new">
            <span class="text-danger" v-if="errors.password_new">{{ errors.password_new[0] }}</span>
          </div>
          <div class="form-group">
            <label>New password Confirm:</label>
            <input type="password" class="form-control" v-model="profile.password_new_confirmation">
            <span class="text-danger" v-if="errors.password_new_confirmation">{{ errors.password_new_confirmation[0] }}</span>
          </div>
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      profile: {},
      roles:[],
      errors: []
    };
  },
  created() {
    axios.get(`http://localhost:8084/api/users/profile/${this.$route.params.id}`)
        .then((response) => {
          this.profile = response.data[0];
          this.profile.password_old = '';
          this.profile.password_new = '';
          this.profile.password_new_confirmation = '';
        }),
        axios.get('http://localhost:8084/api/list-roles')
            .then(response => {
              this.roles = response.data
            })
  },
  methods: {
    editProfile() {
      axios.post(`http://localhost:8084/api/users/update_profile/${this.$route.params.id}`, this.profile)
          .then((response) => {
            this.$router.push({name: 'ListUser'})
          })
          .catch(error => {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors;
            }
          });
    }
  }
};
</script>
