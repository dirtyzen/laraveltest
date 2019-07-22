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
    export default {

        props : ['answer'],

        data(){
          return {
              editing : false,
              body : this.answer.body,
              bodyHtml : this.answer.body_html,
              beforeEditCache : null,
              id : this.answer.id,
              questionId : this.answer.question_id,
          }
        },

        methods : {

            edit(){
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel(){
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            update(){
                axios.patch(this.endpoint, {
                    body: this.body
                })
                    .then(res => {
                        //console.log(res);
                        this.bodyHtml = res.data.body_html;
                        this.editing = false;

                        this.$toast.success(res.data.message, 'Success!', { timeout: 3000, position: 'topRight' });

                    })
                    .catch(err => {
                        //alert(err.response.data.message);
                        this.$toast.error(err.response.data.message, 'Error!', { timeout: 3000 });
                    });
            },

            destroy(){

                this.$toast.question('Are you sure about that?', 'Confirm', {
                    timeout: 5000,
                    close: false,
                    overlay: true,
                    toastOnce: true,
                    id: 'question',
                    zindex: 999,
                    position: 'center',
                    buttons: [

                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(this.endpoint)
                                .then(res => {
                                    $(this.$el).fadeOut(500, () => {
                                        this.$toast.success(res.data.message, 'Success!', { timeout: 3000 });
                                    });
                                });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],

                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]

                    ]
                });

                /*
                if(confirm('Are you sure?')){
                    axios.delete(this.endpoint)
                        .then(res => {
                            $(this.$el).fadeOut(500, () => {
                                alert(res.data.message)
                            });
                        });
                }*/


            }

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