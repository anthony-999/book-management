<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { Head, Link } from "@inertiajs/vue3";
import { toastNotications } from "@/composables/toastNotifications";

const toast = toastNotications();

const props = defineProps({
    category : Object,
    required : true
})

const form = useForm({
    title: props.category.title,
    description: props.category.description,
});

const updateCategory = () => {
    form.put(route("categories.update", props.category.id), {
         onSuccess: () => {
            toast.success('Update Successfully')
        },
        onError: () => {
             toast.error('Failed to update')
        }
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Category
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Content Here -->
                        <form @submit.prevent="updateCategory">
                            <div class="mb-5">
                                <label
                                    for="title"
                                    class="block mb-2 font-medium"
                                    >Category title</label
                                >
                                <input
                                    v-model="form.title"
                                    type="text"
                                    id="name"
                                    class="w-full border border-gray-300 rounded"
                                />
                                <InputError
                                        :message="form.errors.title"
                                        class="mt-1"
                                    />
                            </div>

                            <div class="mb-5">
                                <label
                                    for="Description"
                                    class="block mb-2 font-medium"
                                    >Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    id="description"
                                    class="w-full border border-gray-300 rounded"
                                ></textarea>
                              <InputError
                                        :message="form.errors.description"
                                        class="mt-1"
                                    />
                            </div>

                            <div class="mb-5">
                                <button
                                    type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                        <!-- Content Here -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
