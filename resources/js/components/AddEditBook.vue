<template>
    <div class="container mt-5">
        <div class="row">
            <input type="hidden" name="id" v-model="book.id">
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.title" class="form-control" id="" placeholder="Enter Book Title">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.author" class="form-control" id="" placeholder="Enter Book Author">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.genre" class="form-control" id="" placeholder="Enter Book Genre">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.isbn" class="form-control" id="" placeholder="Enter Book ISBN">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.image" class="form-control" id="" placeholder="Enter Book Image URL">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="date" v-model="book.published" class="form-control" id="" placeholder="Enter Published Date">
            </div>
            <div class="form-group col-md-6 mt-4">
                <input type="text" v-model="book.publisher" class="form-control" id="" placeholder="Enter Book Publisher Name">
            </div>
            <div class="form-group col-md-12 mt-4">
                <textarea name="" v-model="book.description" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group col-md-12 mt-4">
                <button type="submit" class="form-control btn btn-primary rounded submit" @click="submitBookDetail">{{ this.book.id ? 'Update Book' : 'Add book' }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRouter } from "vue-router";
    import { useStore } from "vuex";

    export default{
        data() {
            return {
                router: useRouter(),
                store: useStore(),
                book: {
                    id:'',
                    title :'',
                    author: '',
                    genre: '',
                    isbn: '',
                    image:'',
                    published:'',
                    publisher:'',
                    description:'Enter Description'
                },
                errors : []
            }
        },
        methods: {
            async submitBookDetail() {
                await axios.post(axios.defaults.baseURL+'books/store', this.book)
                .then(response => {
                    if(response.request.status == 200){
                        this.router.push({
                            name:'Home'
                            })
                    }
                }).catch( e => {
                    this.errors.value = e.response.data.message
                })
            },

            fetchBookData() {
                axios.get(axios.defaults.baseURL+'books/detail/'+this.book.id)
                    .then(response => {
                        this.book = response.data.data;
                    });
            },
        },
        mounted() {
            this.book.id = this.$route.params.id ?? null;
            if(this.book.id){
                this.fetchBookData();
            }
        }
    }
</script>
