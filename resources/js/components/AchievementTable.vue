<template>
    <div>
        <div>
            <div class="col-md-12">
                <button v-if="is_admin" class="btn btn-primary" @click="downloadTable">Экспортировать в Excel</button>
                <button class="btn btn-warning" @click="dropFilters">Сбросить фильтры</button>
                <button class="btn btn-warning" @click="returnColumns">Вернуть все колонки</button>
                <p v-if="! is_admin">Баллы за данные достижения - {{studentsScore}}</p>
                <div class="card">
                    <div class="card-header">
                        Столбцы
                    </div>
                    <div class="card-body">
                        <ul>
                            <li v-for="column in workingColumns"><input type="checkbox" v-model="column.value"><p>{{column.text}}</p></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <template v-if="(is_admin && (section !== 'profile'))">
                                <th v-if="workingColumns.student.value"><select v-model="selectedStudent">
                                        <option selected>Все ученики</option>
                                        <option v-for="student in allStudents">{{student}}</option>
                                    </select>
                                </th>
                                <th v-if="workingColumns.form.value">
                                    <select v-model="selectedForm">
                                        <option selected>Все классы</option>
                                        <option v-for="form in allForms">{{form}}</option>
                                    </select>
                                </th>
                            </template>
                            <th v-if="workingColumns.category.value">
                                <select v-model="selectedCategory">
                                    <option selected>Все категории</option>
                                    <option v-for="category in allCategories">{{category}}</option>
                                </select>
                            </th>
                            <th v-if="workingColumns.type.value">
                                <select v-model="selectedType">
                                    <option selected>Все типы</option>
                                    <option v-for="type in allTypes">{{type}}</option>
                                </select>
                            </th>
                            <th v-if="workingColumns.name.value">
                                <select v-model="selectedAchievementName">
                                    <option selected>Все названия</option>
                                    <option v-for="name in allAchievementNames">{{name}}</option>
                                </select>
                            </th>
                            <th v-if="workingColumns.subject.value">
                                <select v-model="selectedSubject">
                                    <option selected>Все предметы</option>
                                    <option v-for="subject in allSubjects">{{subject}}</option>
                                </select>
                            </th>
                            <th v-if="workingColumns.stage.value">
                                <select v-model="selectedStage">
                                    <option selected>Все этапы</option>
                                    <option v-for="stage in allStages">{{stage}}</option>
                                </select>
                            </th>
                            <th v-if="workingColumns.result.value">
                                <select v-model="selectedResult">
                                    <option selected>Все результаты</option>
                                    <option v-for="result in allResults">{{result}}</option>
                                </select>
                            </th>
                            <th v-if="! is_admin">Баллы</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="achievement in sortedAchievement">
                            <template v-if="(is_admin && (section !== 'profile'))">
                                <td v-if="workingColumns.student.value">{{achievement.student}}</td>
                                <td v-if="workingColumns.form.value">{{achievement.form}}</td>
                            </template>
                            <td v-if="workingColumns.category.value">{{achievement.category}}</td>
                            <td v-if="workingColumns.type.value">{{achievement.type}}</td>
                            <td v-if="workingColumns.name.value">{{achievement.name}}</td>
                            <td v-if="workingColumns.subject.value">{{achievement.subject}}</td>
                            <td v-if="workingColumns.stage.value">{{achievement.stage}}</td>
                            <td v-if="workingColumns.result.value">{{achievement.result}}</td>
                            <td v-if="! is_admin">{{achievement.score}}</td>
                            <template v-if="(section === 'created') || (section === 'rejected')">
                                <td v-if="workingColumns.editing.value"><a :href="link(achievement.id, 'edit')"><button class="btn btn-warning">Редактировать</button></a></td>
                                <td v-if="workingColumns.deletion.value"><a :href="link(achievement.id, 'delete')"><button class="btn btn-danger">Удалить</button></a></td>
                                <td v-if="workingColumns.sending.value"><a :href="link(achievement.id, 'send')"><button class="btn btn-success">Отправить</button></a></td>
                            </template>
                            <td v-if="!(is_admin) && (section === 'sent') && (workingColumns.returning.value)"><a :href="link(achievement.id, 'return')"><button class="btn btn-info">Отозвать</button></a></td>
                            <td v-if="is_admin  && (workingColumns.rejection.value)"><a :href="link(achievement.id, 'reject')"><button class="btn btn-danger">Отклонить</button></a></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                selectedForm: 'Все классы',
                selectedStudent: 'Все ученики',
                selectedCategory: 'Все категории',
                selectedType: 'Все типы',
                selectedAchievementName: 'Все названия',
                selectedSubject: 'Все предметы',
                selectedStage: 'Все этапы',
                selectedResult: 'Все результаты',
                allWorkingColumns : {
                    'student': {'text': 'ФИО', 'value': true},
                    'form': {'text': 'Класс', 'value': true},
                    'category': {'text': 'Категории', 'value': true},
                    'type': {'text': 'Тип', 'value': true},
                    'name': {'text': 'Название', 'value': true},
                    'subject': {'text': 'Предмет', 'value': true},
                    'stage': {'text': 'Этап', 'value': true},
                    'result': {'text': 'Результат', 'value': true},
                    'editing': {'text': 'Редактирование', 'value': true},
                    'deletion': {'text': 'Удаление', 'value': true},
                    'sending': {'text': 'Отправка', 'value': true},
                    'returning': {'text': 'Возврат', 'value': true},
                    'rejection': {'text': 'Отклонение', 'value': true}
                }
            }
        },

        props:[
            'achievements', 'is_admin', 'section'
        ],


        methods: {

            setData: function(data){
                let sorted = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let result = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    let isInSorted = true;
                    if (data !== 'all'){
                        isInSorted = (sorted.indexOf(achievement[data]) === -1);
                    }
                    if (
                        (isInSorted) &&
                        ((achievement.form === form) || (form === 'Все классы') || (data === 'form')) &&
                        ((achievement.student === student) || (student === 'Все ученики') || (data === 'student')) &&
                        ((achievement.category === category) || (category === 'Все категории') || (data === 'category')) &&
                        ((achievement.type === type) || (type === 'Все типы') || (data === 'type')) &&
                        ((achievement.name === name) || (name === 'Все названия') || (data === 'name')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы') || (data === 'subject')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы') || (data === 'stage')) &&
                        ((achievement.result === result) || (result === 'Все результаты') || (data === 'result'))
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
                    this.selectedForm = 'Все классы';
                    this.selectedStudent ='Все ученики';
                    this.selectedCategory = 'Все категории';
                    this.selectedType = 'Все типы';
                    this.selectedAchievementName = 'Все названия';
                    this.selectedSubject = 'Все предметы';
                    this.selectedStage = 'Все этапы';
                    this.selectedResult = 'Все результаты';
            },

            link : function (id, action) {
                return '/achievement/' + id + '/' + action
            },

            mySort: function (array) {
                function compare(a, b) {
                    const scoreA = Number(a.score);
                    const scoreB = Number(b.score);
                    let comparison = 0;
                    if (scoreA > scoreB) {
                        comparison = 1;
                    } else if (scoreA < scoreB) {
                        comparison = -1;
                    }
                    return comparison * (-1);
                }
                array.sort(compare)
            },
            returnColumns: function () {
                for (let key in this.workingColumns){
                    this.workingColumns[key].value = true;
                }
            }
        },


        computed: {
            allForms: function () {
                return this.setData('form')
            },
            allStudents: function() {
                return this.setData('student');
            },
            allCategories: function() {
                return this.setData('category');
            },
            allTypes: function() {
                return this.setData('type');
            },
            allAchievementNames: function() {
                return this.setData('name');
            },
            allSubjects: function() {
                return this.setData('subject')
            },
            allStages: function() {
                return this.setData('stage');
            },
            allResults: function() {
                return this.setData('result');
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
            workingColumns:function () {
                let is_admin = this.is_admin;
                let section = this.section;
                let working = {};
                let allWorkingColumns = this.allWorkingColumns;
                for (var key in allWorkingColumns){
                    let column = allWorkingColumns[key];
                    if ((key === 'editing') || (key === 'deletion') || (key === 'sending')) {
                        (((section === 'created') || (section === 'rejected')) && (!is_admin)) && (working[key] = column);
                    } else {
                        if (key === 'returning') {
                            ((section === 'sent') && (!is_admin)) && (working[key] = column);
                        } else {
                            if ((key === 'student') || (key === 'form') || (key === 'rejection')){
                                (is_admin) && (working[key] = column);
                            } else {
                                working[key] = column;
                            }
                        }
                    }
                }
                return working
            }
        }
    }
</script>