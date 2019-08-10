<template>
    <div>
        <button type="button" :class="buttonClass" data-toggle="modal" :data-target="generateId('#modal')">
            {{buttonText}}
        </button>

        <div class="modal fade" :id="generateId('modal')" tabindex="-1" role="dialog" :aria-labelledby="generateId('modalLabel')" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="generateId('modalLabel')">Подтвердите действие</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{modalText}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <a :href="buttonAction" :class="buttonClass">{{buttonText}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        props: ['button-class', 'button-text', 'button-action', 'modal-text', 'id'],

        methods:{
            generateId : function (name) {
                return name + this.id
            }
        }
    }
</script>
