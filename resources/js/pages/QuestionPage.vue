<template>
    <div class="container" v-if="question.id">
    <question :question="question"></question>
    <answers :question="question"></answers>
   </div>
</template>
<script>
import Question from '../components/Question.vue';
import Answers from '../components/Answers.vue'
export default {
    props: ['slug'],

    components: {Question, Answers},

    data() {
        return {
            question: {}
        }
    },

    mounted() {
        this.fetchQuestions()
    },

    methods: {
        fetchQuestions(){
            axios.get(`/questions/${this.slug}`)
                .then(({ data })=> {
                    this.question = data.data
                })
                .catch(error => console.log(error))
        }
    },
}
</script>