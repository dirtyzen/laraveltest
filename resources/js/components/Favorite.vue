<template>
    <a
            title="Favorite"
            v-bind:class="classes"
            v-on:click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorite-count">{{ count }}</span>
    </a>
</template>

<script>
    export default {

        props : ['question'],

        data(){
            return {
                isFavorited : this.question.is_favorited,
                count : this.question.favorites_count,
                id : this.question.id
            }
        },

        computed : {

            classes(){
                return [
                    'favorite', 'mt-2',
                    ! this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
                ];
            },

            endpoint(){
                return `/questions/${this.id}/favorites`;
            },

        },

        methods : {

            toggle(){
                if(! this.signedIn){
                    this.$toast.warning('You must login!', 'Warning', {
                        timeout: 2500,
                        position: 'topLeft'
                    });
                    return;
                }
                this.isFavorited ? this.destroy() : this.create();
            },

            destroy(){

                axios.delete(this.endpoint)
                    .then(res => {
                        this.count--;
                        this.isFavorited = false;
                    })
                    .catch(err => {

                    });


            },

            create(){

                axios.post(this.endpoint)
                    .then(res => {
                        this.count++;
                        this.isFavorited = true;
                    })
                    .catch(err => {

                    });

            }

        }


    }
</script>