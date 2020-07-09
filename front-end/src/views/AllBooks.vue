<template>
    <div class="home col-10 mx-auto py-1 mt-1">
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
                        <router-link :to="{name: 'Edit', params: { id: book.id }}" class="btn btn-primary">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteBook(book.id)">Delete</button>
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
  data () {
    return {
      books: []
    }
  },
  created () {
    axios
      .get('http://localhost:8000/api/books')
      .then(response => {
        this.books = response.data
      })
  },
  methods: {
    deleteBook (id) {
      axios
        .delete(`http://localhost:8000/api/book/delete/${id}`)
        .then(response => {
          const i = this.books.map(item => item.id).indexOf(id) // find index of your object
          this.books.splice(i, 1)
        })
    }
  }
}
</script>
