<template>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                        <hr>

                        <answer v-on:deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>

                        <div class="text-center mt-3" v-if="nextURI">
                            <button class="btn btn-outline-secondary" @click.prevent="fetch(nextURI)">
                                Load More Answers
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Answer from './Answer';

    export default {

        props : ['question'],

        data(){
            return {
                questionId : this.question.id,
                count : this.question.answers_count,
                answers : [],
                nextURI : null,
            }
        },

        created(){
            this.fetch(`/questions/${this.questionId}/answers`);
        },

        methods : {

            fetch(endpoint){
                axios.get(endpoint)
                    .then( ({ data }) => {
                        this.answers.push(... data.data);
                        this.nextURI = data.next_page_url;
                    });
            },

            remove(index){
                this.answers.splice(index, 1);
                this.count--;
            },

        },

        computed : {

            title(){
                return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer');
            }

        },

        components : {
            Answer : Answer,
        }

    }
</script>