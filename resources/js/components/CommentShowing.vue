<template>
    <div>
        <div class="show-comments-link">
            <a v-if="isTable" href = "" class="btn btn-primary" data-toggle="modal" :data-target="generateId('#modalLong')">
                Посмотреть комментарии
            </a>
            <a v-else href = "" data-toggle="modal" :data-target="generateId('#modalLong')">
                Посмотреть комментарии
            </a>
            <div class="modal fade" :id="generateId('modalLong')" tabindex="-1" role="dialog" :aria-labelledby="generateId('modalLongTitle')" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" :id="generateId('modalLongTitle')">Комментарии</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="content">
                                <template v-for="comment in comments">
                                <div v-if="comment.author === 'admin'" class="admin-comment">
                                    <!--<div class="admin-message">-->
                                    <!--<p style="margin-left: 1vw">--><p><strong>Администратор</strong></p>
                                    <!--<p style="margin-bottom: 0; margin-left: 1vw">--><p>{{comment.text}}</p>
                                <!--</div>-->
                                    <!--<div class="admin-triangle-for-message"></div>-->
                                </div>
                                <div v-else class="student-comment">
                                    <p><strong>{{username}}</strong></p>
                                    <p>{{comment.text}}</p>
                                </div>
                                </template>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            if (!this.username){
                this.username = 'Вы'
            }
        },

        props:['comments', 'id', 'username', 'is-table'],

        methods: {
            generateId : function (name) {
                return name + this.id
            }
        }
    }
</script>

<style>
    .admin-comment{
        margin-right: auto;
        margin-left: 0;
        text-align: left;
    }

    .student-comment{
        margin-right: 0;
        margin-left: auto;
        text-align: right;
    }

    .admin-message{
        background:#008000;
        color:#FFFFFF;
        padding-top:4px;
        margin-bottom: 0;

    }
    .admin-triangle-for-message{
        margin-top: 0;
        width: 0;
        height: 0;
        border-top: 5vh solid #008000;
        border-right: 10vw solid transparent;

    }

    .user-triangle-for-message {
        width: 0;
        height: 0;
        border-top: 5vh solid gray;
        border-left: 100vw solid transparent;
    }
</style>
