<template>
    <div class="home col-7 mx-auto py-3 mt-3">
        <h3 class="text-center">Add Book</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addBook">
                    <input type="hidden" >
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="book.name">
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="book.author">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
  import axios from 'axios'
export default {
  data () {
    return {
      book: {}
    }
  },
  methods: {
    addBook () {
      axios
        .post('http://localhost:8000/api/book/add', this.book)
        .then(response => (
          this.$router.push({ name: 'AllBooks' })
          // console.log(response.data)
        ))
        .catch(error => console.log(error))
        .finally(() => this.loading = false)
    }
  }
}
</script>
