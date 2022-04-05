<template>
    <app-layout title="Завершение рабочего дня">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Окончание рабочего дня
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <edit :workingTime=workingTime />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Edit from '@/WorkingTime/Edit.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Edit,
        },

        props: {
            workingTime: Array,
        }
    })
</script>
