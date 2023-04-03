<template>
    <div class="page-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="card form-wrap shadow-sm border-0 p-4 p-md-5">
                        <h3 class="text-center mb-4">Sign In</h3>
                        <p class="text-danger" v-if="error">{{ error }}</p>
                        <form @submit.prevent="login">
                            <div class="form-group my-3">
                                <input type="email" v-model="user.email" class="form-control rounded-left" placeholder="Email" required>
                            </div>
                            <div class="form-group my-3 d-flex">
                                <input type="password" v-model="user.password" class="form-control rounded-left" placeholder="Password" required>
                            </div>
                            <div class="form-group my-3">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive, ref } from 'vue';
    import { useRouter } from "vue-router";
    import { useStore } from "vuex";

    export default {
        setup(){
            const router = useRouter()
            const store = useStore()

            let user = reactive({
                email: '',
                password: ''
            });

            let error = ref('')

            const login = async() =>{
                await axios.post(axios.defaults.baseURL+'login', user)
                    .then(response => {
                        if(response.data.success){
                            store.dispatch('setToken', response.data.data.token)
                            router.push({name:'Home'})
                        }else{
                            error.value = response.data.message;
                        }
                    })
                    .catch(err => {
                        error.value = err;
                    })
            }

            return{
                user,
                login,
                error
            }
        }

    }
</script>
