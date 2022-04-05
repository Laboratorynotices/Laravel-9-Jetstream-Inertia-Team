<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">
                Список отработанных часов.
            </div>

            <table class="table-auto">
                <thead>
                    <tr>
                        <th>Имя пользователя</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(workingTime, id) in workingTimes"
                        :key="id">
                        <td>
                            <a :href="route('workingTime.edit', workingTime.id)">
                                {{ workingTime.user.name }}
                            </a>
                        </td>
                        <td>{{ workingTime.date }}</td>
                        <td>{{ workingTime.begin }} - {{ workingTime.end }}</td>
                        <td>{{ workingTime.description }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 text-gray-500">
                Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
                to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
                you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
                ecosystem to be a breath of fresh air. We hope you love it.
            </div>
        </div>

    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    
    export default defineComponent({
        props: {
            workingTimes: Array
        }
    })
</script>
