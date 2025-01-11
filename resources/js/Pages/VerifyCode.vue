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
                                    :class="{'border-red-500': errors.code}"
                                    placeholder="Введите код из сообщения"
                                    required
                                />
                                <p v-if="errors.code" class="text-sm text-red-500 mt-1">{{ errors.code }}</p>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="mt-4 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <span v-if="form.processing">Подтверждение...</span>
                                <span v-else>Подтвердить</span>
                            </button>
                        </form>

                        <div v-if="message" class="mt-3 text-sm text-green-600">
                            {{ message }}
                        </div>
                        <div v-if="error" class="mt-3 text-sm text-red-600">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        errors: Object, // получаем ошибки через props
        message: String,
        error: String
    },
    data() {
        return {
            form: {
                code: '',
                processing: false
            },
        };
    },
    methods: {
        async verifyCode() {
            this.form.processing = true;

            try {
                await this.$inertia.post('/user/settings/verify-code', {
                    code: this.form.code
                });

                this.message = "Код подтверждения успешно отправлен.";
                this.error = null;
                this.errors = {};

                this.form.code = '';
            } catch (error) {
                if (error.response && error.response.data) {
                    this.error = error.response.data.message;
                    this.message = null;

                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                } else {
                    this.error = "Произошла неизвестная ошибка.";
                }
            } finally {
                this.form.processing = false;
            }
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
}
</style>
