<template>
  <div class="home col-10 mx-auto py-1 mt-1">
    <h3 class="text-center">All User</h3><br/>

    <table class="table table-bordered">
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users" :key="user.id">
        <td>{{ user.id }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.roleName }}</td>
        <td>{{ user.created_at }}</td>
        <td>{{ user.updated_at }}</td>
        <td>
          <div class="btn-group" role="group">
            <router-link :to="{name: 'EditProfile', params: { id: user.id }}" class="btn btn-primary">Edit</router-link>
            <button class="btn btn-danger" @click="deleteBook(user.id)">Delete</button>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      users: []
    }
  },
  created() {
    axios.get('http://localhost:8084/api/list-users')
        .then(response => {
          this.users = response.data
        })
  },
  methods: {
    deleteBook(id) {
      axios.delete(`http://localhost:8084/api/users/delete/${id}`)
          .then(response => {
            const i = this.users.map(item => item.id).indexOf(id) // find index of your object
            this.books.splice(i, 1)
          })
    }
  }
}
</script>
