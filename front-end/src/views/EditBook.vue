<template>
  <div class="home col-7 mx-auto py-3 mt-3">
    <h3 class="text-center">Edit Book</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="updateBook">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="book.name">
            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" class="form-control" v-model="book.author">
            <span class="text-danger" v-if="errors.author">{{ errors.author[0] }}</span>
          </div>
          <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      book: {},
      errors: []
    }
  },
  created() {
    axios.get(`http://localhost:8084/api/book/edit/${this.$route.params.id}`)
        .then((response) => {
          this.book = response.data
          // console.log(response.data);
        })
  },
  methods: {
    updateBook() {
      axios.post(`http://localhost:8084/api/book/update/${this.$route.params.id}`, this.book)
          .then((response) => {
            this.$router.push({name: 'AllBooks'})
          })
          .catch(error => {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors;
            }
          });
    }
  }
}
</script>
