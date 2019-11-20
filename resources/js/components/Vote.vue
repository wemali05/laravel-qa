<template>
<div class="d-fex flex-columns vote-controls">
    <a :title="title('up')" class="vote-up" 
    @click.prevent="voteUp"
    :class="classes">
        <i class="fa fa-caret-up fa-3x"></i>
    </a>
    <span class="votes-count">{{ count }}</span>
    <a :title="title('down')" class="vote-down off" 
      @click.prevent="voteDown"
    :class="classes">
        <i class="fa fa-caret-down fa-3x"></i>
    </a>

    <favorite  v-if="name === 'question'" :question="model"></favorite>
    <accept else :answer="model"></accept>
   
</div>
</template>
<script>
import Favorite from './Favorite.vue';
import Accept from './Accept.vue';

export default {
    props: ['name', 'model'],

     computed: {
        classes(){
            return this.signedIn ? '' : 'off'
        },
        endpoint(){
            return `/${this.name}s/${this.id}/vote`;
        }
    },

    data() {
        return {
            count: this.model.votes_count,
            id: this.model.id
        }
    },

    components:{
        Favorite,
        Accept
    },

    methods: {
        title(voteType){
            let titles = {
                up: `This  ${this.name} is  useful`,
                down: `This  ${this.name} is not  useful`
            };
            return titles[voteType];
        },

        voteUp(){
            this._vote(1);
        },
         voteDown(){
            this._vote(-1);
        },
        _vote(vote){
            if(! this.signedIn){
                this.$toast.warning(`Please login to vote this ${this.name}`, "Warning", {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
            axios.post(this.endpoint, { vote })
                .then(res => {
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    this.count = res.data.votesCount;
                })
        }
    },

   
    
}
</script>


