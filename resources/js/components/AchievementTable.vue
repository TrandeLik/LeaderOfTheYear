<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ученик</th>
                            <th>
                                <select v-model="selectedForm">
                                    <option selected>Все классы</option>
                                    <option v-for="form in allForms">{{form}}</option>
                                </select>
                            </th>
                            <th>Категория</th>
                            <th>Тип</th>
                            <th>Название</th>
                            <th>Предмет</th>
                            <th>Этап</th>
                            <th>Результат</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="achievement in sortedAchievement">
                            <td>{{achievement.user.name}}</td>
                            <td>{{achievement.user.form}}</td>
                            <td>{{achievement.category}}</td>
                            <td>{{achievement.type}}</td>
                            <td>{{achievement.name}}</td>
                            <td>{{achievement.subject}}</td>
                            <td>{{achievement.stage}}</td>
                            <td>{{achievement.result}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                selectedForm: 'Все классы'
            }
        },
        props:[
            'achievements'
        ],
        mounted() {
            this.update()
        },
        methods: {
            update: function () {
                console.log(this.selectedForm);
                console.log(this.achievements)
            },
        },
        computed: {
            allForms: function () {
                let result = [];
                this.achievements.forEach(function (achievement, i, all) {
                    (result.indexOf(achievement.user.form) === -1)&& result.push(achievement.user.form);
                });
                this.update();
                return result;
            },
            sortedAchievement: function () {
                let result = [];
                let form = this.selectedForm;
                this.achievements.forEach(function (achievement, i, all) {
                    if (
                        ((achievement.user.form === form) || (form === 'Все классы'))
                    ){
                        result.push(achievement);
                    }
                });
                this.update();
                return result;
            }
        }
    }
</script>
