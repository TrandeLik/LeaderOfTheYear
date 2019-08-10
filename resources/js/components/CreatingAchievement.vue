<template>
    <div class="card-body">
            <select class="form-control mb-1"  name="category" required v-model="selectedCategory" @change="dropSelections">
                <option selected disabled>Категория</option>
                <option v-for="category in categories">{{category.category}}</option>
            </select>


            <select class="form-control mb-1" v-model="selectedType"
                    v-if="!(selectedCategory === 'Спортивные достижения')" name="type" required
                    :disabled="(selectedCategory === 'Категория')" @change="dropSelectionsOnTypeChange"
            >
                <option selected disabled>Тип</option>
                <option v-for="type in filteredTypes">{{type}}</option>
            </select>


            <input class="form-control mb-1"  v-model="selectedName"
                    v-if="!(selectedCategory === 'Проектная и исследовательская деятельность')"
                    type="text" name="name" :placeholder="placeholderForName"  required
            >


            <input class="form-control mb-1"  v-model="selectedSubject"
                    v-if="!(selectedCategory === 'Спортивные достижения' || selectedCategory === 'Участие в лицейской жизни')"
                    type="text" name="subject" placeholder="Предмет" required
            >


            <select class="form-control mb-1" v-model="selectedStage" v-if="!(selectedCategory === 'Участие в лицейской жизни')"
                    name="stage" required @change="dropSelectionsOnStageChange"
                    :disabled="(selectedType === 'Тип')">
                <option selected disabled>Этап</option>
                <option v-for="stage in filteredStages">{{stage}}</option>
            </select>


            <select class="form-control mb-1" v-model="selectedResult" v-if="!(selectedCategory === 'Участие в лицейской жизни')"
                    name="result" required :disabled="(selectedStage === 'Этап')">
                <option selected disabled>Результат</option>
                <option v-for="result in filteredResults">{{result}}</option>
            </select>


            <input class="form-control mb-1" v-model="selectedDate" v-if="(selectedCategory === 'Участие в лицейской жизни')" type="date">


            <template v-if="isuploadingconfirmationspossible">
                <div class="custom-file">
                    <input accept= "application/pdf,
                                    image/jpeg,
                                    image/pjpeg,
                                    image/x-jps,
                                    image/png" type="file" class="custom-file-input" id="file" name="file" @change="onConfirmationChange">
                     <label class="custom-file-label" for="file" data-browse="Обзор">Подтверждение</label>
                </div><br>
                <small class="form-text text-muted">.png, .jpg, .jpeg, .pdf</small>
            </template>
            <p v-else>К сожалению, загрузка файлов временно невозможна</p>


            <template v-if="action !== '/achievement/add/new'">
                <a v-if="achievement.confirmation !== ''" :href="achievement_href">Скачать подтверждение</a>
                <p v-else>На данный момент подтверждения нет</p>
            </template>

            <div v-if="arecommentsworking" class="accordion" id="accordionExample">
                <button class="btn btn-link col-12 text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Что-то пошло не так? Оставьте комментарий</button>
                <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <textarea class="form-control" name="comment" placeholder = "Комментарий" v-model="studentComment"></textarea>
                </div>
            </div>
            <p v-else>К сожалению, возможность добавлять комментарии отключена</p>


            <button class="btn btn-success col-md-4 offset-md-4" @click="sendData">{{(action === '/achievement/add/new') ? ('Добавить') : ('Изменить')}}</button>

            <div v-if="Object.keys(validationErrors).length !== 0" class="m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">
                <ul v-for="error in validationErrors">
                    <li>{{ error[0] }}</li>
                </ul>
            </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                selectedCategory : 'Категория',
                selectedType : 'Тип',
                selectedName : '',
                selectedSubject : '',
                selectedStage : 'Этап',
                selectedResult : 'Результат',
                selectedDate : '',
                studentComment : '',
                confirmation: null,
                validationErrors : {},
                typesWithDashes : ['Всероссийская олимпиада школьников', 'Московская олимпиада школьников', 'Предпрофессиональная олимпиада']
            }
        },

        mounted() {
            let achievement = this.achievement;
            if (achievement){
                this.selectedCategory = achievement.category;
                this.selectedType = (achievement.type === '-') ? 'Тип' : achievement.type;
                if (this.typesWithDashes.indexOf(achievement.type) !== -1){
                    this.selectedName = achievement.name
                } else {
                    this.selectedName = (achievement.name === '-') ? '' : achievement.name;
                }
                this.selectedSubject = (achievement.subject === '-') ? '' : achievement.subject;
                this.selectedStage = (achievement.stage === '-') ? 'Этап' : achievement.stage;
                this.selectedResult = (achievement.result === '-') ? 'Результат' : achievement.result;
                this.selectedDate = (achievement.date === '-') ? '' : achievement.date;
                this.studentComment = achievement.comment;
            }
        },

        methods: {
             setData: function (name) {
                let data = [];
                let category = this.selectedCategory;
                let selectedType = this.selectedType;
                let stage = this.selectedStage;
                let result = this.selectedResult;
                this.achievementtypes.forEach(function (type) {
                    if (
                        (data.indexOf(type[name]) === -1) &&
                        ((type.category === category) || (category === 'Категория') || (name === 'category')) &&
                        ((type.type === selectedType) || (selectedType === 'Тип') || (name === 'type')) &&
                        ((type.stage === stage) || (stage === 'Этап') || (name === 'stage') || (name === 'type')) &&
                        ((type.result === result) || (result === 'Результат') || (name === 'result') || (name === 'stage') || (name === 'type'))
                    ){
                        data.push(type[name])
                    }
                });
                return data
             },

            dropSelections: function(){
                this.selectedType = 'Тип';
                this.selectedName = '';
                this.selectedSubject = '';
                this.selectedStage = 'Этап';
                this.selectedResult = 'Результат';
            },

            dropSelectionsOnTypeChange : function(){
                this.selectedName = '';
                this.selectedSubject = '';
                this.selectedStage = 'Этап';
                this.selectedResult = 'Результат';
            },

            dropSelectionsOnStageChange : function(){
                this.selectedResult = 'Результат';
            },

            dropSelectionsAfterValidation : function(errors){
                 this.dataPreparation('', false);
                 if ('category' in errors){
                     this.dropSelections()
                 }

                 if ('name' in errors){
                     this.selectedName = ''
                 }

                 if ('result' in errors){
                     this.selectedResult = 'Результат'
                 }

                 if ('stage' in errors){
                     this.selectedStage = 'Этап'
                 }

                 if ('subject' in errors){
                     this.selectedSubject = ''
                 }
                 if ('type' in errors){
                     this.selectedType = 'Тип'
                 }
                 if ('date' in errors){
                     this.selectedDate = ''
                 }
            },

            dataPreparation : function(value, dropValue){
                 if (dropValue) {
                     if (this.selectedCategory === 'Категория') {
                         this.selectedCategory = ''
                     }

                     if (this.selectedType === 'Тип') {
                         this.selectedType = ''
                     }

                     if (this.selectedStage === 'Этап') {
                         this.selectedStage = ''
                     }

                     if (this.selectedResult === 'Результат') {
                         this.selectedResult = ''
                     }
                 }

                 if (this.selectedCategory === 'Спортивные достижения'){
                     if (dropValue) {
                         this.selectedType = value;
                     }
                     this.selectedSubject = value;
                     this.selectedDate = value;
                     return
                 }

                 if (this.selectedCategory === 'Интеллектуальные соревнования'){
                     this.selectedDate = value;
                     return
                 }

                if (this.selectedCategory === 'Проектная и исследовательская деятельность'){
                    this.selectedName = value;
                    this.selectedDate = value;
                    return
                }

                if (this.selectedCategory === 'Участие в лицейской жизни'){
                    if (this.selectedDate === value) {
                        this.selectedDate = ''
                    }
                    this.selectedSubject = value;
                    if (dropValue) {
                        this.selectedStage = value;
                        this.selectedResult = value;
                    }
                }
            },

             sendData: function () {
                 const config = { 'content-type': 'multipart/form-data' };
                 this.dataPreparation('-', true);
                 const formData = new FormData;
                 formData.append('category', this.selectedCategory);
                 formData.append('type', this.selectedType);
                 formData.append('name', this.selectedName);
                 formData.append('subject', this.selectedSubject);
                 formData.append('stage', this.selectedStage);
                 formData.append('result', this.selectedResult);
                 formData.append('date', this.selectedDate);
                 formData.append('file', this.confirmation);
                 if (this.studentComment !== ''){
                     formData.append('comment', this.studentComment)
                 }
                 // window.axios = require('axios');
                 //
                 // window.axios.defaults.headers.common = {
                 //     'X-Requested-With': 'XMLHttpRequest',
                 //     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 // };
                 axios.post(this.action, formData, config)
                     .then(response => {
                         if (response.data == 'Данный тип файлов загрузить нельзя :('){
                             this.validationErrors ={'typeError' : ['Данный тип файлов загрузить нельзя :(']}
                         } else {
                             location = "/user"
                         }
                     })
                     .catch(error => {
                         this.validationErrors = error.response.data.errors;
                         console.log(this.validationErrors);
                         this.dropSelectionsAfterValidation(this.validationErrors);
                         if (this.selectedCategory === '') {
                             this.selectedCategory = 'Категория';
                         }
                         console.log(error.response.data)
                     });
             },

             onConfirmationChange: function (event) {
                 this.confirmation = event.target.files[0];
             }
        },
        computed:{

            filteredTypes: function () {
                return this.setData('type')
            },

            filteredStages: function () {
                return this.setData('stage')
            },

            filteredResults: function () {
                return this.setData('result')
            },
            placeholderForName: function () {
                if (this.selectedCategory === 'Интеллектуальные соревнования'){
                    return 'Название олимпиады'
                }
                if (this.selectedCategory === 'Спортивные достижения'){
                    return 'Название соревнований'
                }
                return 'Название мероприятия'
            }
        },

        props:['categories', 'isuploadingconfirmationspossible', 'arecommentsworking',
            'achievementtypes', 'achievement', 'action', 'achievement_href']
    }
</script>
