<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">
                Новая запись.
            </div>

            <form @submit.prevent="submit">
                <label for="description">Описание:</label>
                <textarea id="description" v-model="form.description" />
                <br />
                <button type="submit">Submit</button>
            </form>

            <div class="mt-6 text-gray-500">
                Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
                to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
                you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
                ecosystem to be a breath of fresh air.
            </div>
        </div>

    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { reactive } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    
    export default defineComponent({
        props: {
            workingTimes: Array
        },

        setup () {
            const form = reactive({
                description: 'Описание дел, которые запланированы на сегодня.',
            })

            function submit() {
                Inertia.post('/workingTime/store', form)
            }

            return { form, submit }
        },
    })
</script>
