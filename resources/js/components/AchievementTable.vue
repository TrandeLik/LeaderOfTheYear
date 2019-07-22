<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <button class="btn btn-primary" @click="downloadTable">Экспортировать в Excel</button>
                <button class="btn btn-warning" @click="dropFilters">Сбросить фильтры</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <select v-model="selectedStudent">
                                    <option selected>Все ученики</option>
                                    <option v-for="student in allStudents">{{student}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedForm">
                                    <option selected>Все классы</option>
                                    <option v-for="form in allForms">{{form}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedCategory">
                                    <option selected>Все категории</option>
                                    <option v-for="category in allCategories">{{category}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedType">
                                    <option selected>Все типы</option>
                                    <option v-for="type in allTypes">{{type}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedAchievementName">
                                    <option selected>Все названия</option>
                                    <option v-for="name in allAchievementNames">{{name}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedSubject">
                                    <option selected>Все предметы</option>
                                    <option v-for="subject in allSubjects">{{subject}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedStage">
                                    <option selected>Все этапы</option>
                                    <option v-for="stage in allStages">{{stage}}</option>
                                </select>
                            </th>
                            <th>
                                <select v-model="selectedResult">
                                    <option selected>Все результаты</option>
                                    <option v-for="result in allResults">{{result}}</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="achievement in sortedAchievement">
                            <td>{{achievement.student}}</td>
                            <td>{{achievement.form}}</td>
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
                selectedForm: 'Все классы',
                selectedStudent: 'Все ученики',
                selectedCategory: 'Все категории',
                selectedType: 'Все типы',
                selectedAchievementName: 'Все названия',
                selectedSubject: 'Все предметы',
                selectedStage: 'Все этапы',
                selectedResult: 'Все результаты'
            }
        },

        props:[
            'achievements'
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
                return sorted.sort();
            },
            downloadTable: function () {
                let tableData = this.sortedAchievement;
                axios.post('/achievements/all', {table: tableData})
                    .then(response => {
                        window.open('/achievements/all/download/' + response.data);
                    })
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
            }
        }
    }
</script>