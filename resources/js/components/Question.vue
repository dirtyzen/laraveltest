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

                                    <button v-if="authorize('modify', question)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">
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
    export default {

        props : ['question'],

        data(){
            return {
                title : this.question.title,
                body : this.question.body,
                bodyHtml : this.question.body_html,
                editing : false
            }
        },

        methods : {

            update(){
                alert('test');
            },

            edit(){
                this.editing = true;
            },

            cancel(){
                this.editing = false;
            }

        },

    }
</script>