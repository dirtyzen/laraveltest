<template>

    <div class="media post">

        <vote :model="answer" name="answer"></vote>

        <div class="media-body">

            <form v-if="editing" @submit.prevent="update">

                <div class="form-group">
                    <textarea class="form-control" rows="10" v-model="body" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>

            </form>

            <div v-if="editing === false">

                <div v-html="bodyHtml"></div>

                <div class="row">

                    <div class="col-4">

                        <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>

                        <button v-if="authorize('modify', answer)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">
                            Delete
                        </button>

                    </div>

                    <div class="col-4"></div>

                    <div class="col-4">

                        <user-info v-bind:model="answer" label="Answered"></user-info>

                    </div>

                </div>
            </div>

        </div>

    </div>

</template>

<script>

    import Vote from './Vote';
    import UserInfo from './UserInfo';
    import modification from '../mixins/modification';

    export default {

        props : ['answer'],

        mixins : [modification],

        components : {
            Vote,
            UserInfo
        },

        data(){
          return {
              id : this.answer.id,
              editing : false,
              body : this.answer.body,
              bodyHtml : this.answer.body_html,
              beforeEditCache : null,
              questionId : this.answer.question_id,
          }
        },

        methods : {

            setEditCache(){
                this.beforeEditCache = this.body;
            },

            restoreFromCache(){
                this.body = this.beforeEditCache;
            },

            payload(){
                return {
                    body: this.body
                }
            },

            delete(){
                axios.delete(this.endpoint)
                    .then(({data}) => {
                        this.$toast.success(data.message, 'Success', {timeout: 2500});
                        this.$emit('deleted');
                    });
            },


        },

        computed : {

            isInvalid(){
                return this.body.length < 10;
            },

            endpoint(){
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },

    }
</script>