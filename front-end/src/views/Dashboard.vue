<template>
  <div>
    <h3 class="text-center">All Books</h3><br/>

    <table class="table table-bordered">
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Author</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="book in books" :key="book.id">
        <td>{{ book.id }}</td>
        <td>{{ book.name }}</td>
        <td>{{ book.author }}</td>
        <td>{{ book.created_at }}</td>
        <td>{{ book.updated_at }}</td>
        <td>
          <div class="btn-group" role="group">
            <router-link :to="{name: 'edit', params: { id: book.id }}" class="btn btn-primary">Edit</router-link>
            <button class="btn btn-danger" @click="deleteBook(book.id)">Delete</button>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import User from "../apis/User";

export default {
  data() {
    return {
      user: null
    };
  },

  mounted() {
    User.auth().then(response => {
      this.user = response.data;
    });
  }
};
</script>
