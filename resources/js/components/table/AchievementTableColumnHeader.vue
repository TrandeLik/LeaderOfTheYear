<template>
    <th v-if="isWorking[columnKey].value">
        <select v-model="selected[columnKey]">
            <option selected>{{firstSelected}}</option>
            <option v-for="item in list[columnKey]">{{item}}</option>
        </select>
    </th>
</template>

<script>
    export default {
        props:['isWorking', 'selected', 'firstSelected', 'list', 'columnKey']
    }
</script>
