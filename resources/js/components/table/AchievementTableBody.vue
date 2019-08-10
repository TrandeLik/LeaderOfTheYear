<template>
    <tbody>
        <tr v-for="achievement in sortedAchievement" :class="rowStyle(achievement.status)">
            <td v-if="workingColumns.status.value">{{achievement.status}}</td>
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
            <td v-if="workingColumns.date.value">{{achievement.date}}</td>
            <td v-if="! is_admin">{{achievement.score}}</td>
            <td v-if="workingColumns.download.value">
                <a v-if="achievement.confirmation !== ''" :href="link(achievement.id, 'download_confirmation')" class="btn btn-outline-secondary">Подтверждение</a>
            </td>
            <td>
                <a v-if="workingColumns.editing.value && (((achievement.status === 'Созданные, но не отправленные') ||
                (achievement.status === 'Отклоненные')) && (!is_admin))" :href="link(achievement.id, 'edit')">
                    <button class="btn btn-warning">Редактировать</button>
                </a>
            </td>
            <td>
                <confirm-action v-if="workingColumns.deletion.value && (((achievement.status === 'Созданные, но не отправленные') ||
                (achievement.status === 'Отклоненные')) && (!is_admin))"
                                    :button-class="'btn btn-danger'"
                                    :button-text="'Удалить'"
                                    :button-action="'/achievement/'+achievement.id+'/delete'"
                                    :modal-text="'Вы уверены, что хотите удалить достижение?'"
                                    :id="'delete'+achievement.id"
                ></confirm-action>     
                
            </td>
            <td>
                <a v-if="workingColumns.sending.value && (((achievement.status === 'Созданные, но не отправленные') ||
                 (achievement.status === 'Отклоненные')) && (!is_admin))" :href="link(achievement.id, 'send')">
                    <button class="btn btn-success">Отправить</button>
                </a>
            </td>
            <td>
                <confirm-action v-if="!(is_admin) && (achievement.status === 'Отправленные, но не проверенные') && (workingColumns.returning.value)"
                                    :button-class="'btn btn-info'"
                                    :button-text="'Отозвать'"
                                    :button-action="'/achievement/'+achievement.id+'/return'"
                                    :modal-text="'Вы уверены, что хотите отозвать достижение?'"
                                    :id="'return'+achievement.id"
                ></confirm-action>  
            </td>
            <td>
                <reject-achievement v-if="is_admin  && (workingColumns.rejection.value) &&
                    (achievement.status !== 'Отклоненные') && (achievement.status !== 'Созданные, но не отправленные')"
                    :actionAddress="link(achievement.id, 'reject')"
                    :id="achievement.id"
                    :achievement="achievement">
                </reject-achievement>
            </td>
            <td>
                <a v-if="is_admin  && (workingColumns.confirmation.value) &&
                    (achievement.status !== 'Проверенные') && (achievement.status !== 'Созданные, но не отправленные')"
                    :href="link(achievement.id, 'confirm')"><button class="btn btn-success">Одобрить</button>
                </a>
            </td>
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
            rowStyle: function (status) {
                if (status === 'Созданные, но не отправленные') {
                    return 'table-primary'
                }
                if (status === 'Отклоненные') {
                    return 'table-danger'
                }
                if (status === 'Отправленные, но не проверенные') {
                    return 'table-secondary'
                }
                if (status === 'Проверенные') {
                    return 'table-success'
                }
            }
        }
    }
</script>
