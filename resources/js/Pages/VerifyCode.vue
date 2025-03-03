<template>
    <Head title="Подтверждение кода" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Подтверждение кода
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="verifyCode">
                            <div class="form-group">
                                <label for="code" class="block text-sm font-medium text-gray-700">Введите код</label>
                                <input
                                    type="text"
                                    v-model="form.code"
                                    id="code"
                                    class="mt-2 p-2 w-full border border-gray-300 rounded-md"
                                    :class="{'border-red-500': form.errors.code}"
                                    placeholder="Введите код из сообщения"
                                    required
                                />
                                <p v-if="form.errors.code" class="text-sm text-red-500 mt-1">{{ form.errors.code }}</p>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing || processing"
                                class="mt-4 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <span v-if="form.processing || processing">Подтверждение...</span>
                                <span v-else>Подтвердить</span>
                            </button>
                        </form>

                        <div v-if="props.message" class="mt-3 text-sm text-green-600">
                            {{ props.message }}
                        </div>
                        <div v-if="props.error" class="mt-3 text-sm text-red-600">
                            {{ props.error }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    errors: Object,
    message: String,
    error: String
});

const form = useForm({
    code: ''
});

const processing = ref(false);

const verifyCode = async () => {
    processing.value = true;
    
    try {
        await form.post('/user/settings/verify-code');
        form.reset();
    } catch (error) {
        console.error('Error:', error);
    } finally {
        processing.value = false;
    }
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
}
</style>
