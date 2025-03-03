<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const { props } = usePage();  // Получаем данные, переданные через Inertia

const successMessage = ref(null);  // Сообщение об успехе
const errorMessage = ref(null);  // Сообщение об ошибке

// Используем useForm для управления формой
const form = useForm({
    key: '',
    value: '',
    method: 'sms',
});

// Функция для отправки формы
const submitForm = () => {
    form.post('/user/settings/update', {
        onFinish: () => {
            // Очистка формы после успешной отправки
            form.reset();

            // Дополнительно можно сбросить сообщения
            successMessage.value = 'Код подтверждения успешно отправлен';
            errorMessage.value = null;
        },
        onError: (errors) => {
            // Обработка ошибок и отображение сообщения об ошибке
            errorMessage.value = 'Произошла ошибка при отправке.';
            successMessage.value = null;

            // Вы можете отобразить подробные ошибки формы
            console.log(errors);  // Для отладки
        }
    });
};
</script>

<template>
    <Head title="Изменить настройку" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Изменить настройку
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label for="key" class="block text-sm font-semibold text-gray-700">Ключ настройки</label>
                        <input
                            type="text"
                            id="key"
                            v-model="form.key"
                            class="mt-2 p-2 w-full border border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="mb-4">
                        <label for="value" class="block text-sm font-semibold text-gray-700">Значение настройки</label>
                        <input
                            type="text"
                            id="value"
                            v-model="form.value"
                            class="mt-2 p-2 w-full border border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="mb-4">
                        <label for="method" class="block text-sm font-semibold text-gray-700">Метод подтверждения</label>
                        <select
                            id="method"
                            v-model="form.method"
                            class="mt-2 p-2 w-full border border-gray-300 rounded-md"
                        >
                            <option value="sms">SMS</option>
                            <option value="mail">Email</option>
                            <option value="telegram">Telegram</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-700 transition"
                    >
                        Обновить настройку
                    </button>
                </form>

                <!-- Отображаем сообщение об успехе, если оно передано -->
                <div v-if="successMessage" class="mt-4 text-sm text-green-600">
                    {{ successMessage }}
                </div>

                <!-- Если есть ошибка -->
                <div v-if="errorMessage" class="mt-4 text-sm text-red-600">
                    {{ errorMessage }}
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.container {
    max-width: 600px;
}
</style>
