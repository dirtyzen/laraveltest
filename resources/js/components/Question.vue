<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <form v-if="editing" @submit.prevent="update" class="card-body">

                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>

                    <hr>

                    <div class="media">

                        <div class="media-body">

                            <div class="form-group">
                                <textarea class="form-control" rows="10" v-model="body" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                            <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>


                        </div>
                    </div>

                </form>

                <div v-else class="card-body">

                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>{{ title }}</h2>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">

                        <vote :model="question" name="question"></vote>

                        <div class="media-body">

                            <div v-html="bodyHtml"></div>

                            <div class="row">
                                <div class="col-4">

                                    <a v-if="authorize('modify', question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>

                                    <button v-if="authorize('deleteQuestion', question)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>

                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">

                                    <user-info v-bind:model="question" label="Asked"></user-info>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>

    import Vote from './Vote';
    import UserInfo from './UserInfo';

    export default {

        props : ['question'],

        components : {
            Vote,
            UserInfo
        },

        data(){
            return {
                title : this.question.title,
                body : this.question.body,
                bodyHtml : this.question.body_html,
                editing : false,
                id : this.question.id,
                beforeEditCache : {},
            }
        },

        computed : {

            isInvalid(){
                return this.body.length < 10 || this.title.length < 10;
            },

            endpoint(){
                return `/questions/${this.id}`;
            },

        },

        methods : {

            update(){

                axios.put(this.endpoint, {
                    body : this.body,
                    title : this.title
                }).catch(({ response }) => {
                    this.$toast.error(response.data.message, 'Error', { timeout: 3000 });
                }).then(({ data }) => {
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, 'Success', { timeout: 3000 });
                    this.editing = false;
                });

            },

            destroy() {
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
                                .then(({data}) => {

                                    this.$toast.success(data.message, 'Success', {timeout: 2500});

                                    setTimeout(() => {
                                        window.location.href = "/questions";
                                    }, 3500);

                                })
                                .catch(({ response }) => {
                                    this.$toast.error(response.data.message, 'Error', {timeout: 2500});
                                });


                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }, true],

                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }]

                    ]
                });
            },

            edit(){
                this.beforeEditCache = {
                    body : this.body,
                    title : this.title
                };

                this.editing = true;
            },

            cancel(){
                this.body = this.beforeEditCache.body;
                this.title = this.beforeEditCache.title;
                this.editing = false;
            },

        },

    }
</script>