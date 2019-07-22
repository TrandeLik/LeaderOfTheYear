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
            update: function () {
                console.log(this.selectedForm);
                console.log(this.achievements)
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
                let result = [];
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if(
                        (result.indexOf(achievement.user.form) === -1) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.user.form)
                    }
                });
                return result;
            },

            allStudents: function() {
                let result = [];
                let form = this.selectedForm;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if (
                        (result.indexOf(achievement.user.name) === -1) &&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.user.name)
                    }
                });
                return result;
            },

            allCategories: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if(
                        (result.indexOf(achievement.category) === -1)&&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.category)
                    }
                });
                return result;
            },

            allTypes: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if(
                        (result.indexOf(achievement.type) === -1)&&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.type)
                    }
                });
                return result;
            },

            allAchievementNames: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if(
                        (result.indexOf(achievement.name) === -1)&&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.name)
                    }
                });
                return result;
            },

            allSubjects: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let stage = this.selectedStage;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if (
                        (result.indexOf(achievement.subject) === -1)&&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.subject)
                    }
                });
                return result;
            },

            allStages: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let results = this.selectedResult;
                this.achievements.forEach(function (achievement) {
                    if (
                        (result.indexOf(achievement.stage) === -1)&&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.result === results) || (results === 'Все результаты'))
                    ){
                        result.push(achievement.stage)
                    }
                });
                return result;
            },

            allResults: function() {
                let result = [];
                let form = this.selectedForm;
                let student = this.selectedStudent;
                let category = this.selectedCategory;
                let type = this.selectedType;
                let name = this.selectedAchievementName;
                let subject = this.selectedSubject;
                let stage = this.selectedStage;
                this.achievements.forEach(function (achievement) {
                    if (
                        (result.indexOf(achievement.result) === -1) &&
                        ((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы'))
                    ){ result.push(achievement.result)}
                });
                return result;
            },



            sortedAchievement: function () {
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
                    if (((achievement.user.form === form) || (form === 'Все классы')) &&
                        ((achievement.user.name === student) || (student === 'Все ученики')) &&
                        ((achievement.category === category) || (category === 'Все категории')) &&
                        ((achievement.type === type) || (type === 'Все типы')) &&
                        ((achievement.name === name) || (name === 'Все названия')) &&
                        ((achievement.subject === subject) || (subject === 'Все предметы')) &&
                        ((achievement.stage === stage) || (stage === 'Все этапы')) &&
                        ((achievement.result === result) || (result === 'Все результаты'))){
                        sorted.push(achievement);
                    }
                });
                this.update();
                return sorted;
            }
        }
    }
</script>