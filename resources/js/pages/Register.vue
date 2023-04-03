<template>
    <div class="page-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="card form-wrap shadow-sm border-0 p-4 p-md-5">
                        <h3 class="text-center mb-4">Sign Up</h3>
                        <p class="text-danger" v-for="error in errors" :key="error">
                            <span v-for="err in error" :key="err">{{ err }}</span>
                        </p>
                        <form @submit.prevent="register">
                            <div class="form-group my-3">
                                <input type="text" v-model="user.name" class="form-control rounded-left" placeholder="Name" required>
                            </div>
                            <div class="form-group my-3">
                                <input type="email" v-model="user.email" class="form-control rounded-left" placeholder="Email" required>
                            </div>
                            <div class="form-group my-3 d-flex">
                                <input type="password" v-model="user.password" class="form-control rounded-left" placeholder="Password" required>
                            </div>
                            <div class="form-group my-3 d-flex">
                                <input type="password" v-model="user.c_password" class="form-control rounded-left" placeholder="Confirm Password" required>
                            </div>
                            <div class="form-group my-3">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue';
    import { useRouter } from "vue-router";
    import { useStore } from "vuex";

    export default{
        setup(){
            const router = useRouter()
            const store = useStore()

            let user = reactive({
                name :'',
                email: '',
                password: '',
                c_password: '',
            });

            let errors = ref([])

            const register = async() =>{
                await axios.post(axios.defaults.baseURL+'register', user)
                .then(response => {
                    if(response.data.success){
                        store.dispatch('setToken', response.data.data.token)
                        router.push({name:'Home'})
                    }
                }).catch( e => {
                    errors.value = e.response.data.message
                })
            }

            return{
                user,
                register,
                errors
            }
        }
    }
</script>

