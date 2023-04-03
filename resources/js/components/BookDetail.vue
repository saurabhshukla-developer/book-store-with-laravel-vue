<template>
    <div class="container my-5">
        <div class="row py-5">
            <div class="col-lg-5">
                <img :src=book.image class="img-responsive img-thumbnail" alt="...">
            </div>
            <div class="col-lg-7 text-dark">
                <h2>{{ book['title'] }}</h2>
                <hr>
                <p>{{ book['description'] }}</p>
                <div>
                    <ul>
                        <li>
                            <strong>Author : </strong>{{ book['author'] }}
                        </li>
                        <li>
                            <strong>Genre : </strong> {{ book['genre'] }}
                        </li>
                        <li>
                            <strong>Publisher : </strong>  {{ book['publisher'] }}
                        </li>
                        <li>
                            <strong>Published @ </strong>  {{ book['published'] }}
                        </li>
                        <li>
                            <strong>ISBN : </strong> {{ book['isbn'] }}
                        </li>
                    </ul>
                </div>
                <a href="#" @click="bookListingPage" class="btn btn-primary">Back To Listing</a>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRouter } from 'vue-router';
    export default {
        data() {
            return {
                router: useRouter(),
                book: []
            }
        },
        methods: {
            async fetchData() {
                axios.get(axios.defaults.baseURL+'books/detail/'+this.$route.params.id)
                    .then(response => {
                        this.book = response.data.data;
                    });
            },

            bookListingPage() {
                this.router.push({
                  name:'Home'
                })
            },
        },
        mounted() {
            this.fetchData();
        }
    }
</script>