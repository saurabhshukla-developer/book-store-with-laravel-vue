<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="d-inline-block">Books</h2>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary float-end" @click="addBook" v-if="$store.getters.isLogin">Add Book</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="accordionFilters">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="myFilters">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Filter Books
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="myFilters" data-bs-parent="#accordionFilters">
                            <div class="accordion-body">
                                <div class="row">
                                    <small>Note* - Please enter full values in the options below to filter books.</small>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="text" v-model="bookTitle" class="form-control" id="" placeholder="Enter Title">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="text" v-model="bookAuthor" class="form-control" id="" placeholder="Enter Author">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="text" v-model="bookGenre" class="form-control" id="" placeholder="Enter Genre">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="text" v-model="bookIsbn" class="form-control" id="" placeholder="Enter ISBN">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="date" v-model="bookPublished" class="form-control" id="" placeholder="Enter Published Date">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <input type="text" v-model="bookPublisher" class="form-control" id="" placeholder="Enter Publisher Name">
                                    </div>
                                    <div class="form-group col-md-12 mt-4">
                                        <a class="btn btn-primary" @click="filterBooks">Filter Books</a>
                                        <a class="btn btn-primary ms-2" @click="clearFilters">Clear Filters</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <input class="form-control my-2" type="search" placeholder="Search Books" aria-label="Search" @input="onInputChange" value="" title="Enter 3 or more characters for search to work">
                <p v-if="errorMessage" class="text-danger mb-0">{{ errorMessage }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12 mt-4" v-for="book in books" :key="book.id">
              <div class="card">
                  <img :src=book.image class="card-img-top img-thumbnail" alt="...">
                  <div class="card-body">
                      <h5 class="card-title">{{ book['title'] }}</h5>
                      <div>
                          <span class="card-text">{{ book['author'] }}</span>&nbsp;|&nbsp;
                          <span class="card-text">{{ book['genre'] }}</span>
                      </div>
                      <div class="row mt-1">
                        <div class="col d-grid p-0">
                            <a href="#" class="btn btn-primary m-1" @click="loadBook(book.id)" v-if="$store.getters.isLogin">View</a>
                            <a href="#" class="btn btn-primary m-1" @click="loadBook(book.id)" v-if="!($store.getters.isLogin)">Read More</a>
                        </div>
                        <div class="col d-grid p-0" v-if="$store.getters.isLogin">
                            <a href="#" class="btn btn-primary m-1" @click="editBook(book.id)">Edit</a>
                        </div>
                        <div class="col d-grid p-0" v-if="$store.getters.isLogin">
                            <a href="#" class="btn btn-primary m-1" @click="deleteBook(book.id)">Delete</a>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav class="mt-5 d-flex container justify-content-center">
                    <ul class="pagination">
                        <li class="page-item m-1" :class="{ disabled: !link.url, active: link.active }" v-for="link in paginationLinks" :key="link.label">
                            <a class="page-link" href="#" @click.prevent="fetchBooks(link.url)" v-html="link.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRouter } from "vue-router";
    import { useStore } from "vuex";

    export default {
        data() {
            return {
                router: useRouter(),
                store: useStore(),
                books: [],
                errorMessage: false,
                searchText: '',
                bookTitle: null,
                bookAuthor: null,
                bookGenre: null,
                bookIsbn: null,
                bookPublished: null,
                bookPublisher: null,
                filters: null,
                paginationLinks: []
            }
        },
        methods: {
            async fetchBooks(url = axios.defaults.baseURL+'books/list/') {
                // let url = axios.defaults.baseURL+'books/list/';

                if(this.filters){
                    url += this.filters;
                }

                if(this.searchText != ''){
                    url += this.filters ? '&search='+this.searchText : '?search='+this.searchText;
                }

                axios.get(url)
                    .then(response => {
                        this.books = response.data.data;
                        this.paginationLinks = response.data.links;

                        if (this.paginationLinks.length <= 1) {
                            this.paginationLinks = [];
                        }
                    });

            },

            loadBook(bookId) {
                this.router.push({
                  name:'BookDetail',
                  params: { id: bookId }
                })
            },

            addBook(){
                this.router.push({
                    name:'AddEditBook'
                })
            },

            editBook(bookId){
                this.router.push({
                    name:'EditBookDetail',
                    params: { id: bookId }
                })
            },

            deleteBook(bookId){
                if(confirm("Do you really want to delete?")){
                    axios.delete(axios.defaults.baseURL+'books/delete/'+bookId)
                        .then(response => {
                            if(response.request.status == 200){
                                this.fetchBooks();
                        }
                    });
                }
            },

            onInputChange(event) {
                this.errorMessage = false;
                const value = event.target.value.trim();
                const isValid = /^[a-zA-Z0-9\s]+$/.test(value);
                if (isValid || value == '') {
                    this.searchText = value;
                    this.fetchBooks();
                }
                else if(!isValid){
                    this.errorMessage = 'Please enter a valid search term';
                    this.searchText = '';
                }
                else{
                    this.fetchBooks();
                }

            },

            filterBooks(){
                let filterUrl = '?';
                if(this.bookTitle){
                    filterUrl += 'title='+this.bookTitle;
                }
                if(this.bookAuthor){
                    filterUrl += (filterUrl == '?') ? 'author=' : '&author=';
                    filterUrl += this.bookAuthor;
                }
                if(this.bookGenre){
                    filterUrl += (filterUrl == '?') ? 'genre=' : '&genre=';
                    filterUrl += this.bookGenre;
                }
                if(this.bookIsbn){
                    filterUrl += (filterUrl == '?') ? 'isbn=' : '&isbn=';
                    filterUrl += this.bookIsbn;
                }
                if(this.bookPublished){
                    filterUrl += (filterUrl == '?') ? 'published=' : '&published=';
                    filterUrl += this.bookPublished;
                }
                if(this.bookPublisher){
                    filterUrl += (filterUrl == '?') ? 'publisher=' : '&publisher=';
                    filterUrl += this.bookPublisher;
                }

                if(filterUrl != '?'){
                    this.filters = filterUrl;
                    this.fetchBooks();
                }
            },

            clearFilters(){
                this.filters = null;
                this.bookTitle = null;
                this.bookAuthor = null;
                this.bookGenre = null;
                this.bookIsbn = null;
                this.bookPublished = null;
                this.bookPublisher = null;
                this.fetchBooks();
            }
        },
        mounted() {
            this.fetchBooks();
        }
    }
</script>
