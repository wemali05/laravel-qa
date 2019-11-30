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
            let token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMDIwZmU4OTU4YjEwYzU4MGE1OTE3M2QwODQyNzQ5NDA0MmVhOGIzOWUyZGE3OGU5ZTFiNTNkNzI2YmFjYWZjMDJhYzQ5MGFkZDlhOTNhOWUiLCJpYXQiOjE1NzUwNDk4MDYsIm5iZiI6MTU3NTA0OTgwNiwiZXhwIjoxNjA2NjcyMjA2LCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.qA3tQ_LeAH5vhlD6EbY5cfNA9sMagd2Es8eBbxRvN4DEujKZb4P0uGnTJTTdgq8cexnmmstGO-iTcWA6qyzV2GJHtiyfbykahZah0-OoFB8j1rRqPQfdtV5iPldXkmMzuUb8lqUawgaNP3NjcFlS8NKihvWSLNzWvfchBQzIklQVsDR7jD1vYlbfarihD0wfOjkEJxZqY-EykPsRvPMqGZEhXNHyZDgPNI219RSpww7jTBJDuTDjDi9AGgwbim9QtzrY2v8yh2vp89LpIRYCShgQCno_oJyQeI-GmsrBpdoTth8o0CV0Sur3y9lx68sktrpb13jU1p13v7lfEqYx8AwwYmmvD2xZLrJNuT-jj3z-8n1V_1T_BZvmGpHwZ11JdP8lnQXvgpYZDIyTNV3GfJMqF4yUr6XsoiYNRSbhuIvcGjVqAgdWUHsT9YxYcfehIod_Ob3EkPuVk0vM90rv5VhehApgy8yKlw06n6ET-sqJXZTkQJf2kLAinSiJvfHeJ8-HfyLuooBBKmeWDpFZ_Cm0PDyziZwLrApxLh-dsGSC1sZC_80Vr5-rBgNofKO6Kpc6QkD2hqxdbaPlg4Oij6eLPSShKrFKP1VL1gWnVtaZ2m6Af1svjmETCVjfGQhkSCrX2xyIYFQ0AGWPmm7_MkYyRYeIa06g2hnuWpOl_Ok";
            axios.post('http://laravel-qa.loc/api/questions', [], {headers: { 'Authorization' : 'Bearer '+ token}}, {data})
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