<template>
    <thead>
        <tr>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'status'"  :selected="selected" :firstSelected="'Все статусы'" :list="filters"></achievement-table-column-header>
            <template v-if="(is_admin && (section !== 'profile'))">
                <achievement-table-column-header :isWorking="workingColumns" :columnKey="'student'"  :selected="selected" :firstSelected="'Все ученики'" :list="filters"></achievement-table-column-header>
                <achievement-table-column-header :isWorking="workingColumns" :columnKey="'form'"  :selected="selected" :firstSelected="'Все классы'" :list="filters"></achievement-table-column-header>
            </template>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'category'"  :selected="selected" :firstSelected="'Все категории'" :list="filters"></achievement-table-column-header>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'type'"  :selected="selected" :firstSelected="'Все типы'" :list="filters"></achievement-table-column-header>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'name'"  :selected="selected" :firstSelected="'Все названия'" :list="filters"></achievement-table-column-header>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'subject'"  :selected="selected" :firstSelected="'Все предметы'" :list="filters"></achievement-table-column-header>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'stage'"  :selected="selected" :firstSelected="'Все этапы'" :list="filters"></achievement-table-column-header>
            <achievement-table-column-header :isWorking="workingColumns" :columnKey="'result'"  :selected="selected" :firstSelected="'Все результаты'" :list="filters"></achievement-table-column-header>
            <th v-if="! is_admin">Баллы</th>
        </tr>
    </thead>
</template>

<script>
    import achievementTableColumnHeader from './AchievementTableColumnHeader.vue'
    export default {
        components: {
            achievementTableColumnHeader
        },
        props: ['workingColumns', 'filters', 'selected', 'is_admin', 'section']
    }
</script>
