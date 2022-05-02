<template>
    <app-layout title="Учёт рабочего времени">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Учёт рабочего времени. Обзор.
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <index />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Index from '@/WorkingTime/Index.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Index,
        }
    })
</script>
