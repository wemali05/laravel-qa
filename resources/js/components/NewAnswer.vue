<template>
    <div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your answer</h3>
                </div>
                <hr>
                <form @submit.prevent="create">
                    <div class="form-group">
                    <m-editor :body="body" name="new-answer">
                        <textarea id="" cols="30" rows="7"
                            class="form-control" required v-model="body" name="body"> </textarea>
                     </m-editor>   
                    </div>
                    <div class="form-group">
                        <button type="submit"  :disabled="isInvalid" class="btn btn-lg btn-outline-primary">
                         <spinner :small="true" :min-width="59.22" v-if="$root.loading"></spinner>
                         <span v-else> Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import MEditor from '../components/MEditor.vue';

export default {
    props: ['questionId'],

    components: { MEditor },

    data(){
        return{
            body: ''
        }
    },

    computed:{
        isInvalid () {
            return !this.signedIn || this.body.length < 10;
        }
    },

    methods: {
        create(){
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body  })
                .catch( error => {
                    this.$toast.warning(error.response.data.message, "Warning")
                })
                .then( ({data}) => {
                    this.$toast.success(data.message, "Success");
                    this.body = '';
                    this.$emit('created', data.answer);
                })
        }
    },

}
</script>