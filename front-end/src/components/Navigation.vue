<template>
  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
      <div class="navbar-header">
        <router-link class="navbar-brand" to="/">IDS VN</router-link>
      </div>
      <ul class="nav navbar-nav">
        <router-link class="nav-item nav-link" :to="{ name: 'AllBooks' }">Dashboard</router-link>
        <router-link v-if="!isLoggedIn" class="nav-item nav-link" :to="{ name: 'Login' }">Login</router-link>
        <router-link v-if="!isLoggedIn" class="nav-item nav-link" :to="{ name: 'Register' }">Register</router-link>
        <router-link v-if="isLoggedIn" class="nav-item nav-link" :to="{ name: 'Add' }">Add Book</router-link>
        <router-link v-if="isLoggedIn" class="nav-item nav-link" :to="{ name: 'ListUser' }">List User</router-link>
        <a class="nav-item nav-link" v-if="isLoggedIn" @click.prevent="logout" href="#">Logout</a>
      </ul>
    </div>
  </nav>
</template>

<script>
import User from "../apis/User";

export default {
  data() {
    return {
      isLoggedIn: false
    };
  },

  mounted() {
    this.$root.$on("login", () => {
      this.isLoggedIn = true;
    });

    this.isLoggedIn = !!localStorage.getItem("auth");
  },

  methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("auth");
        this.isLoggedIn = false;
        this.$router.push("/").catch(() => {
        });
      });
    }
  }
};
</script>

<style>
.router-link-exact-active {
  color: #ffffff !important;
  transition: all 0.25s;
}
</style>
