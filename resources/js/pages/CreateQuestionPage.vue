<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Ask Question</h2>
                            <div class="ml-auto">
                                <router-link :to="{ name: 'questions' }" class="btn btn-outline-secondary">Back to all Questions</router-link>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <question-form @submitted="create"></question-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import QuestionForm from '../components/QuestionForm.vue'
import EventBus from '../event-bus'
export default {
    components: { QuestionForm },
    methods: {
        create (data) {
            let token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiOGUwODZjZTQwOTEyMjBmZmYwZDNiM2VlMGEwNzdhNDcxNWM2NWQ3YTBmNzc4NDBiNjg3ZDYyZDI1YzU2OGUxMjAzMjM1NjhjZGJiNmE1YWIiLCJpYXQiOjE1NzUyNzE0MTUsIm5iZiI6MTU3NTI3MTQxNSwiZXhwIjoxNjA2ODkzODE1LCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.iazxhAKgmvUm4mgMXvR3koALBpOsOBfKUERSlyHU2Ux_Of_F8uKvUVpt2pRCSXbpfRzXC2Wxbn8CAt4Qybfi8Eiu3EFkwc9Tw8MqAu1w9xd_WBYh3xFtUgS1VPThB5HqKxCkg86NKeevpyRJvr4W-uXORVoZGAGK7sO8jzqMuEpkyALW46q0EouDH7D79TntGzAPuhYnqeYwkOlBqth9YoY-bmEwJTcJO_mAd9ra-VQ14oTEB-aHsrkGi_JrGFHtLdL-diIPTMrezGO8YK7szvgkjNwBIYfDj78BdEbuEYq1YPHnM-JJWrvpjC-jEE8RkxMj2yDtsE_udTwB5ANEQyrTeB3ERzCK4XttHBfJ1hQ-7G3oknckAL2xrw34-Y5pVaMxncjd9BmDyjDlbN0XOKAQnkNQ9-nru1KSYttKqda37E1ZGhJWX0h0hw8yWgch2D6lyXG0YzO7w-qC55E7XWMwHoH_K-a5nz0xZrebMNIP-xBFo5O0KMpuYwpM-9So0FNTU3ZkSmSeuk9Rucm1nFe2w3P4nCy9La1HIOXtYnA1oaLda38_ovwRoSyVoJPQPzgi8boed7CapYa7Mwy0KzYUJye5UHlkuHCA2b8aSOrUcl8HJKmB5ZwgOeka30zS_UWwpgGzzUgitdKOVZSQDMRCGO4PL6rUbshezn7c32c";
            axios.post('/questions', data, {headers: { 'Authorization' : 'Bearer '+ token}})
                 .then(({ data }) => {
                     this.$router.push({ name: 'questions' })
                     this.$toast.success(data.message, "Success")
                 })
                 .catch(({ response }) => {
                     EventBus.$emit('error', response.data.errors)
                 })
        }
    }
}
</script> 