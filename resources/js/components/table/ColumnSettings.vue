<template>
    <div class="accordion" id="settings">
        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseOne">Скрыть некоторые столбцы</button>
        <div id="collapseSettings" class="collapse hide" aria-labelledby="headingOne" data-parent="#settings">
            <div class="card">
                <div class="card-header">
                    Столбцы
                </div>
                <div class="card-body">
                    <ul>
                        <li v-for="column in workingColumns"><input type="checkbox" v-model="column.value"><p>{{column.text}}</p></li>
                    </ul>
                </div>
                <button class="btn btn-warning" @click="returnColumns">Вернуть все колонки</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'columnSettings',
        props: ['allWorkingColumns', 'is_admin', 'section'],
        methods: {
            returnColumns: function () {
                for (let key in this.workingColumns){
                    this.workingColumns[key].value = true;
                }
            },
        },
        computed: {
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
