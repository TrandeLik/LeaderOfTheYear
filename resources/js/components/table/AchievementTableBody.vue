<template>
    <tbody>
        <tr v-for="achievement in sortedAchievement" :class="rowStyle(achievement.status)">
            <td v-if="workingColumns.status.value">{{translate(achievement.status)}}</td>
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
            <template v-if="((achievement.status === 'created') || (achievement.status === 'rejected')) && (!is_admin)">
                <td v-if="workingColumns.editing.value"><a :href="link(achievement.id, 'edit')"><button class="btn btn-warning">Редактировать</button></a></td>
                <td v-if="workingColumns.deletion.value"><a :href="link(achievement.id, 'delete')"><button class="btn btn-danger">Удалить</button></a></td>
                <td v-if="workingColumns.sending.value"><a :href="link(achievement.id, 'send')"><button class="btn btn-success">Отправить</button></a></td>
            </template>
            <td v-if="!(is_admin) && (achievement.status === 'sent') && (workingColumns.returning.value)"><a :href="link(achievement.id, 'return')"><button class="btn btn-info">Отозвать</button></a></td>
            <td v-if="is_admin  && (workingColumns.rejection.value) && (achievement.status !== 'rejected') && (achievement.status !== 'created')"><reject-achievement :actionAddress="link(achievement.id, 'reject')"></reject-achievement></td>
        </tr>
    </tbody>
</template>

<script>
    export default {
        props: ['is_admin', 'section', 'workingColumns', 'sortedAchievement'],
        methods: {
            link : function (id, action) {
                return '/achievement/' + id + '/' + action
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
            rowStyle: function (status) {
                if (status === 'created') {
                    return 'table-primary'
                }
                if (status === 'rejected') {
                    return 'table-danger'
                }
                if (status === 'sent') {
                    return 'table-secondary'
                }
                if (status === 'confirmed') {
                    return 'table-success'
                }
            }
        }
    }
</script>
