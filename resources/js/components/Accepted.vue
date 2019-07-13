<template>
    <div>

        <a
                v-if="canAccept"
                title="Best Answer"
                v-bind:class="classes"
                v-on:click.prevent="create"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>


        <a
                v-if="accepted"
                title="The question owner accept this answer as best answer"
                v-bind:class="classes"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>


    </div>
</template>

<script>
    export default {

        props : ['answer'],

        data(){
            return {
                isBest : this.answer.is_best,
                id : this.answer.id,
            }
        },

        methods : {

            create(){
                axios.post(`/answers/${this.id}/accept`)
                    .then(res => {
                        this.$toast.success(res.data.message, 'Success', {
                            timeout: 3000,
                            position: 'topLeft'
                        });

                        this.isBest = true;
                    })
                    .catch(err => {

                    });
            }

        },

        computed : {

            canAccept() {
                return this.authorize('accept', this.answer);
            },

            accepted() {
                return ! this.canAccept && this.isBest;
            },

            classes(){
                return [
                    'mt-2',
                    this.isBest ? 'vote-accepted' : '',
                ];
            }

        }

    }
</script>