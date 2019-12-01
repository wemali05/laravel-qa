<template>
      <div class="media post">
      <div class="d-flex flex-column counters">
          <div class="votes">
              <strong>{{ question.votes_count}}</strong>
              {{ str_plural('vote', question.votes_count )}}
          </div>
          <div :class="statusClasses">
              <strong>{{ question.answers_count}}</strong>
              {{ str_plural('answer', question.votes_count )}}
          </div>
          <div class="views">
              {{ question.answers_count + " " +str_plural('view', question.votes_count )}}
          </div>
      </div>
      <div class="media-body">
          <div class="d-flex align-items-center">
              <h3 class="mt-0"> <a href="#"> {{ question.title }} </a></h3>
              <div class="ml-auto">

                 <router-link  :to="{ name: 'questions.edit', params: { id: question.id } }" 
                            v-if="authorize('modify', question)" 
                            class="btn btn-sm btn-outline-info">Edit</router-link>
                                        
                  <form v-if="authorize('deleteQuestion', question)" class="form-delete" action="#" method="post">
                   
                      <button class="btn btn-sm btn-outline-danger" type="submit"
                          onClick="return confirm('Are you sure!!')">Delete</button>
                  </form>
              
              </div>
          </div>

          <p class="lead">
              Asked By
              <a href="#">{{ question.user.name }}</a>
              <small class="text-muted"> {{ question.created_date }}</small></p>
          <div class="excerpt">
              {{ question.excerpt }}</div>
      </div>
  </div>
</template>
<script>
export default {
    props: ['question'],

    methods:{
        str_plural(str, count){
            return str + (count> 1 ? 's' : '');
        }
    },

    computed: {
        statusClasses(){
            return [
                'status',
                this.question.status
            ]
        }
    },
}
</script>