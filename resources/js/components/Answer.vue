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