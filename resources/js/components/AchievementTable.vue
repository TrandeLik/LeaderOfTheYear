<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Тут будет табличка</div>

                    <div class="card-body">
                        Надеюсь
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'achievements'
        ],
        mounted() {
            this.update()
        },
        methods: {
            update: function () {
                console.log(this.achievements)
            }  
        }
    }
</script>
