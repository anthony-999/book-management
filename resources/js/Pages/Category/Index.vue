<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import { toastNotications } from "@/composables/toastNotifications";
import Pagination from "@/Components/Pagination.vue";
import Modal from "@/Components/Modal.vue";
import ViewModal from "@/Components/ViewModal.vue";
import EditModal from "@/Components/EditModal.vue";
import AddModal from "@/Components/AddModal.vue";
import InputError from "@/Components/InputError.vue";
import SearchInput from "@/Components/SearchInput.vue";
import { deleteConfirmation } from "@/composables/deleteConfirmation";
import { ref, watch } from "vue";

const toast = toastNotications();

const props = defineProps({
    categories: Object,
    required: true,
    filters: Object,
});

const showViewModal = ref(false);
const showEditModal = ref(false);
const showAddModal = ref(false);
const selectedCategory = ref(null);

const openViewModal = (category) => {
    selectedCategory.value = category;
    showViewModal.value = true;
};

const closeViewModal = () => {
    showViewModal.value = false;
    selectedCategory.value = null;
};

// for edit form Modal
const editForm = useForm({
    title: "",
    description: "",
});

// for add form Modal
const addForm = useForm({
    title: "",
    description: "",
});

const openEditModal = (category) => {
    selectedCategory.value = category;
    editForm.title = category.title;
    editForm.description = category.description;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    selectedCategory.value = null;
    editForm.reset();
};

const openAddModal = () => {
    showAddModal.value = true;
};

const closeAddModal = () => {
    showAddModal.value = false;
};

const updateCategory = () => {
    editForm.put(route("categories.update", selectedCategory.value.id), {
        onSuccess: () => {
            toast.success("Update Successfully");
            closeEditModal();
        },
        onError: () => {
            toast.error("Failed to update");
        },
    });
};

const createCategory = () => {
    addForm.post(route("categories.store"), {
        onSuccess: () => {
            toast.success("Create Successfully");
            addForm.reset();
            closeAddModal();
        },
    });
};

const deleteCategory = async (category) => {
    const confirmed = await deleteConfirmation();

    if (!confirmed) return;

    router.delete(route("categories.destroy", category), {
        onSuccess: () => {
            toast.success("Delete Successfully");
        },
        onError: () => {
            toast.error("Failed to delete");
        },
    });
};

// const deleteCategory = (categoryID) => {
//     if (confirm("Are you sure you want to delete")) {
//         router.delete(route("categories.destroy", categoryID), {
//             onSuccess: () => {
//                 toast.success("Delete Successfully");
//             },
//             onError: () => {
//                 toast.error("Failed to delete");
//             },
//         });
//     }
// };
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Categories
                </h2>

                <button
                    @click="openAddModal()"
                    class="px-2 py-1 text-white bg-indigo-600 rounded"
                >
                    New Category
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <SearchInput
                    routeName="categories.index"
                    placeholder="Search categories..."
                    queryParam="search"
                    :initialValue="filters.search"
                />

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Title</th>
                                    <th class="text-start">Description</th>
                                    <th class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody
                                v-if="
                                    categories.data &&
                                    categories.data.length > 0
                                "
                            >
                                <tr
                                    class="text-lg"
                                    v-for="category in categories.data"
                                    :key="category.id"
                                >
                                    <td>{{ category.id }}</td>
                                    <td>{{ category.title }}</td>
                                    <td>{{ category.description }}</td>

                                    <td class="flex my-1 space-x-2">
                                        <button
                                            @click="openViewModal(category)"
                                            class="p-1 text-center text-white bg-blue-500 rounded"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                />
                                            </svg>
                                        </button>

                                        <button
                                            @click="openEditModal(category)"
                                            class="p-1 text-center text-white bg-yellow-500 rounded"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                                />
                                            </svg>
                                        </button>

                                        <button
                                            @click="deleteCategory(category.id)"
                                            class="p-1 text-center text-white bg-red-600 rounded"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr>
                                    <td
                                        colspan="4"
                                        class="py-4 text-center text-gray-500"
                                    >
                                        No data available
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination  -->
                        <Pagination :links="categories.links" />

                        <!-- View  -->
                        <ViewModal
                            :show="showViewModal"
                            @close="closeViewModal"
                        >
                            <div class="p-6 space-y-4">
                                <h2 class="text-xl font-bold text-gray-900">
                                    Category Details
                                </h2>

                                <!-- Details Section -->
                                <div class="space-y-2">
                                    <div>
                                        <span
                                            class="block text-sm font-medium text-gray-500"
                                            >ID</span
                                        >
                                        <p class="text-gray-900">
                                            {{ selectedCategory?.id }}
                                        </p>
                                    </div>

                                    <div>
                                        <span
                                            class="block text-sm font-medium text-gray-500"
                                            >Title</span
                                        >
                                        <p class="text-gray-900">
                                            {{ selectedCategory?.title }}
                                        </p>
                                    </div>

                                    <div>
                                        <span
                                            class="block text-sm font-medium text-gray-500"
                                            >Description</span
                                        >
                                        <p class="text-gray-900">
                                            {{ selectedCategory?.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </ViewModal>
                        <!-- View  -->

                        <!-- Edit modal  -->
                        <EditModal
                            :show="showEditModal"
                            @close="closeEditModal"
                        >
                            <!-- Content Here -->
                            <form @submit.prevent="updateCategory">
                                <div class="p-6 space-y-4">
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Update Category
                                    </h2>
                                    <div class="mb-5">
                                        <label
                                            for="title"
                                            class="block mb-2 font-medium"
                                            >Category title</label
                                        >
                                        <input
                                            v-model="editForm.title"
                                            type="text"
                                            id="name"
                                            class="w-full border border-gray-300 rounded"
                                        />
                                        <InputError
                                            :message="editForm.errors.title"
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
                                            v-model="editForm.description"
                                            id="description"
                                            class="w-full border border-gray-300 rounded"
                                            rows="5"
                                        ></textarea>
                                        <InputError
                                            :message="
                                                editForm.errors.description
                                            "
                                            class="mt-1"
                                        />
                                    </div>

                                    <div class="flex justify-end mb-5">
                                        <button
                                            @click="closeEditModal"
                                            class="w-full p-2 mx-2 text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 sm:w-auto dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                        >
                                            Close
                                        </button>

                                        <button
                                            type="submit"
                                            class="w-full p-2 text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- Content Here -->
                        </EditModal>
                        <!-- Edit modal  -->

                        <!-- Add modal  -->
                        <AddModal :show="showAddModal" @close="closeAddModal">
                            <div class="p-6 space-y-4">
                                <!-- Content Here -->
                                <form @submit.prevent="createCategory">
                                    <div class="mb-5">
                                        <label
                                            for="title"
                                            class="block mb-2 font-medium"
                                            >Category title</label
                                        >
                                        <input
                                            v-model="addForm.title"
                                            type="text"
                                            id="name"
                                            class="w-full border border-gray-300 rounded"
                                        />
                                        <InputError
                                            :message="addForm.errors.title"
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
                                            v-model="addForm.description"
                                            id="description"
                                            class="w-full border border-gray-300 rounded"
                                        ></textarea>
                                        <InputError
                                            :message="
                                                addForm.errors.description
                                            "
                                            class="mt-1"
                                        />
                                    </div>

                                    <div class="flex justify-end mb-5">
                                        <button
                                            type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </form>
                                <!-- Content Here -->
                            </div>
                        </AddModal>
                        <!-- add modal  -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
