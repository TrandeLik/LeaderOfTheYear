<template>
    <div>
        <div>
            <div class="col-md-12">
                <button v-if="is_admin" class="btn btn-primary" @click="downloadTable">Экспортировать в Excel</button>
                <button class="btn btn-warning" @click="dropFilters">Сбросить фильтры</button>
                <br><br><column-settings :is_admin="is_admin" :section="section" :allWorkingColumns = 'allWorkingColumns'></column-settings><br>
                <p v-if="! is_admin">Баллы за данные достижения (без учета условий конкурса, т.е. баллы, которые вы получите, если учесть все выбранные достижения) - {{studentsScore}}</p>
                <div class="table-responsive">
                <table class="table">
                    <achievement-table-head :section="section" :workingColumns="allWorkingColumns" :selected="selected" :filters="filters" :is_admin="is_admin"></achievement-table-head>
                    <achievement-table-body :is_admin='is_admin' :section='section' :workingColumns="allWorkingColumns" :sortedAchievement="sortedAchievement"></achievement-table-body>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import columnSettings from './ColumnSettings.vue'
    import achievementTableBody from './AchievementTableBody.vue'
    import achievementTableHead from './AchievementTableHead.vue'

    export default {

        components: {
            columnSettings, achievementTableBody, achievementTableHead
        },

        data(){
            return{
                selected : {
                    'form': 'Все классы',
                    'student': 'Все ученики',
                    'category': 'Все категории',
                    'type': 'Все типы',
                    'name': 'Все названия',
                    'subject': 'Все предметы',
                    'stage': 'Все этапы',
                    'result': 'Все результаты',
                    'status': 'Все статусы',
                    'date': 'Все даты'
                },

                allWorkingColumns : {
                    'status': {'text': 'Статус', 'value': true},
                    'student': {'text': 'ФИО', 'value': true},
                    'form': {'text': 'Класс', 'value': true},
                    'category': {'text': 'Категория', 'value': true},
                    'type': {'text': 'Тип', 'value': true},
                    'name': {'text': 'Название', 'value': true},
                    'subject': {'text': 'Предмет', 'value': true},
                    'stage': {'text': 'Этап', 'value': true},
                    'result': {'text': 'Результат', 'value': true},
                    'date': {'text': 'Дата', 'value': true},
                    'download': {'text': 'Ссылка на подтверждение', 'value': true},
                    'comments': {'text': 'Комментарии', 'value': true},
                    'editing': {'text': 'Редактирование', 'value': true},
                    'deletion': {'text': 'Удаление', 'value': true},
                    'sending': {'text': 'Отправка', 'value': true},
                    'returning': {'text': 'Возврат', 'value': true},
                    'rejection': {'text': 'Отклонение', 'value': true},
                    'confirmation': {'text': 'Одобрение', 'value': true},
                },
            }
        },

        props:[
            'achievements', 'is_admin', 'section'
        ],


        methods: {

            setData: function(data){
                let sorted = [];
                let form = this.selected.form;
                let student = this.selected.student;
                let category = this.selected.category;
                let type = this.selected.type;
                let name = this.selected.name;
                let subject = this.selected.subject;
                let stage = this.selected.stage;
                let result = this.selected.result;
                let date = this.selected.date;
                let status = this.selected.status;
                let translator = this.translate;
                this.achievements.forEach(function (achievement) {
                    let isInSorted = true;
                    if (data !== 'all'){
                        isInSorted = (sorted.indexOf(achievement[data]) === -1);
                    }
                    if (
                        (isInSorted) &&
                        ((translator(achievement.status) === status) || (status === 'Все статусы') || (data === 'status')) &&
                        ((achievement.form === form) || (form === 'Все классы') || (data === 'form')) &&
                        ((achievement.student === student) || (student === 'Все ученики') || (data === 'student')) &&
                        ((achievement.category === category) || (category === 'Все категории') || (data === 'category')) &&
                        ((achievement.type === type) || (type === 'Все типы') || (data === 'type')) &&
                        ((achievement.name === name) || (name === 'Все названия') || (data === 'name')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы') || (data === 'subject')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы') || (data === 'stage')) &&
                        ((achievement.result === result) || (result === 'Все результаты') || (data === 'result')) &&
                        ((achievement.date === date) || (date === 'Все даты') || (data === 'date'))
                    ){
                        if (data === 'all') {
                            sorted.push(achievement)
                        } else {
                            sorted.push(achievement[data])
                        }
                    }
                });
                if (data === 'all'){
                    this.mySort(sorted);
                }
                return sorted.sort();
            },

            downloadTable: function () {
                let tableData = this.sortedAchievement;
                let selectedColumns = this.workingColumns;
                axios.post('/achievements/all', {table: tableData, columns: selectedColumns})
                    .then(response => {
                        window.open('/achievements/all/download/' + response.data);
                    }).catch(error => {
                    console.log(error.response.data);
                });
            },

            dropFilters: function () {
                    this.selected.form = 'Все статусы';
                    this.selected.form = 'Все классы';
                    this.selected.student ='Все ученики';
                    this.selected.category = 'Все категории';
                    this.selected.type = 'Все типы';
                    this.selected.name = 'Все названия';
                    this.selected.subject = 'Все предметы';
                    this.selected.stage = 'Все этапы';
                    this.selected.result = 'Все результаты';
                    this.selected.status = 'Все статусы';
                    this.selected.date = 'Все даты';
            },

            mySort: function (array) {
                function compare(a, b) {
                    let scoreA = Number(a.score);
                    let scoreB = Number(b.score);
                    let statusA = a.status;
                    let statusB = b.status;
                    let comparison = 0;
                    if (statusA === 'confirmed'){
                        comparison = -1
                    } else {
                         if (statusB === 'confirmed'){
                             comparison = 1
                         } else {
                            if (statusA === 'sent'){
                                comparison = -1
                            } else {
                                if (statusB === 'sent'){
                                    comparison = 1
                                } else {
                                    if (statusA === 'rejected'){
                                        comparison = -1
                                    } else {
                                        if (statusB === 'rejected'){
                                            comparison = 1
                                        } else {
                                            if (scoreA > scoreB) {
                                                comparison = 1;
                                            } else if (scoreA < scoreB) {
                                                comparison = -1;
                                            }
                                        }
                                    }
                                }
                            }
                         }
                    }
                    return comparison * (-1);
                }
                array.sort(compare)
            },

            translate: function (s) {
                if (s === 'created'){
                    return 'Созданные, но не отправленные'
                }
                if (s === 'rejected'){
                    return 'Отклоненные'
                }
                if (s === 'sent'){
                    return 'Отправленные, но не проверенные'
                }
                if (s === 'confirmed'){
                    return 'Проверенные'
                }
            },

            changeSortKey: function () {
                let key = this.sortKey;
                this.sortKey = key * (-1)
            }


        },


        computed: {
            filters: function(){
                let forms = this.setData('form');
                let students = this.setData('student');
                let categories = this.setData('category');
                let types = this.setData('type');
                let names = this.setData('name');
                let subjects = this.setData('subject');
                let stages = this.setData('stage');
                let results = this.setData('result');
                let date= this.setData('date');
                let status = this.setData('status');
                let resultFilters = {
                    'form' : forms,
                    'student' : students,
                    'category' : categories,
                    'type' : types,
                    'name' : names,
                    'subject' : subjects,
                    'stage' : stages,
                    'result' : results,
                    'date' : date,
                    'status' : status
                };
                return resultFilters
            },

            sortedAchievement: function () {
                return this.setData('all');
            },

            studentsScore: function () {
                let score = 0;
                this.sortedAchievement.forEach( function (achievement) {
                    score += Number(achievement.score);
                });
                return score;
            },
        }
    }
</script>