<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-light">
            <div class="container py-2">
                <router-link :to="{ name: 'Home' }" class="navbar-brand">Home</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarText" aria-controls="mainNavbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbarText">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'Login' }" v-if="$store.getters.getToken == 0">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'Register' }" v-if="$store.getters.getToken == 0">Register</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'Dashboard' }" v-if="$store.getters.getToken != 0">Dashboard</router-link>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" type="button" @click="logout" v-if="$store.getters.getToken != 0">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'

    export default{
        setup(){
            const router = useRouter();
            const store = useStore();

            function logout(){
                store.dispatch('removeToken');
                router.push({name:'Home'})
            }

            return {
                logout
            }
        }
    }
</script>