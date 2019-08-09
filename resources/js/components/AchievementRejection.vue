<template>
    <div>
    <button type="button" class="btn btn-danger" data-toggle="modal" :data-target="generateId('#rejectionModal')">
        Отклонить
    </button>
    <div class="modal fade" :id="generateId('rejectionModal')" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" :id="generateId('rejection')">Отклонение заявки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="accordion" :id="generateId('accordionRejection')">
                        Вы действительно хотите отклонить эту заявку?
                        <a href = "" style="color:blue;" data-toggle="collapse" :data-target="generateId('#collapseRejection')" aria-expanded="true" aria-controls="collapseOne">
                            Оставьте комментарий с объяснением вашего решения
                        </a>
                        <div :id="generateId('collapseRejection')" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionRejection">

                                <textarea v-model="adminComment" name="comment" placeholder = "Комментарий"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
                    <input type="submit" class="btn btn-danger" value="Отклонить" @click="sendComment()">
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['actionAddress', 'id', 'achievement'],
        data(){
            return{
                adminComment: ''
            }
        },

        mounted(){
            window.axios = require('axios');

            window.axios.defaults.headers.common = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

         methods: {
             sendComment: function() {
                 let comment = this.adminComment;
                 let href = this.actionAddress;
                 axios.post(href, {comment: comment})
                     .then(response => {
                         // if (window.location.pathname !== '/admin'){
                         //     this.achievement.status = 'rejected'
                         // } else {
                             location.reload()
                         //}
                     }).catch(error => {
                        console.log(error.response.data);
                    });
             },

             generateId : function (name) {
                 return name + String(this.id)
             }
         }

    }
</script>
