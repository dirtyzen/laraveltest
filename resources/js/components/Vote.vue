<template>
    <div class="d-flex flex-column vote-controls">

        <a @click="voteUp" :title="title('up')" class="vote-up" :class="classes" >
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="vote-count">{{ count }}</span>

        <a @click="voteDown" :title="title('down')" class="vote-down" :class="classes" >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>


        <favorite v-if="name === 'question'" :question="model"></favorite>
        <accepted v-if="name === 'answer'" :answer="model"></accepted>

    </div>
</template>

<script>

    import Favorite from './Favorite';
    import Accepted from './Accepted';

    export default {

        props : ['model', 'name'],

        data(){
          return {
              count : this.model.votes_count || 0,
              id : this.model.id,
          }
        },

        components : {
            Favorite : Favorite,
            Accepted : Accepted
        },

        methods : {

            title(Type){
                let Titles = {
                    'up' : `This ${this.name} is useful`,
                    'down' : `This ${this.name} is not useful`,
                };

                return Titles[Type];
            },

            voteUp(){
                this._vote(1);
            },

            voteDown(){
                this._vote(-1);
            },

            _vote(vote){

                if(!this.signedIn){
                    this.$toast.warning(`Please login to vote the ${this.name}`, 'Warning', {
                        timeout: 3000,
                        position: 'center'
                    });

                    return;
                }

                axios.post(this.endpoint, { vote: vote})
                    .then(res => {
                        this.$toast.success(res.data.message, "Success", {
                            timeout : 3000,
                            position : 'topLeft',
                        });

                        this.count = res.data.votesCount;
                    });
            }

        },

        computed : {
            classes(){
                return this.signedIn ? '' : 'off';
            },

            endpoint(){
                return `/${this.name}s/${this.id}/vote`;
            }
        }

    }
</script>
