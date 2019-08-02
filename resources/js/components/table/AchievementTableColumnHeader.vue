<template>
    <th v-if="isWorking[columnKey].value">
        <select v-model="selected[columnKey]">
            <option selected>{{firstSelected}}</option>
            <option v-for="item in list[columnKey]">{{translate(item)}}</option>
        </select>
    </th>
</template>

<script>
    export default {
        props:['isWorking', 'selected', 'firstSelected', 'list', 'columnKey'],
        methods:{
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
                return s
            }
        }
    }
</script>
