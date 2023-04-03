import { createWebHistory, createRouter } from "vue-router";
import Home from './pages/Home.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Dashboard from './pages/Dashboard.vue';
import BookDetail from './components/BookDetail.vue';
import AddEditBook from './components/AddEditBook.vue';
import store from './store'

const routes = [
    {
        path : '/',
        name : 'Home',
        component : Home
    },
    {
        path : '/login',
        name : 'Login',
        component : Login,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/register',
        name : 'Register',
        component : Register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/dashboard',
        name : 'Dashboard',
        component : Dashboard,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/book-detail/:id',
        name : 'BookDetail',
        component : BookDetail,
    },
    {
        path : '/edit-book/:id',
        name : 'EditBookDetail',
        component : AddEditBook,
    },
    {
        path : '/add-book',
        name : 'AddEditBook',
        component : AddEditBook,
        meta:{
            requiresAuth:true
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken != 0){
        return { name : 'Dashboard'}
    }
})

export default router;