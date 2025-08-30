<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import AddModal from "@/Components/AddModal.vue";
import InputError from "@/Components/InputError.vue";
import { toastNotications } from "@/composables/toastNotifications";
import { ref } from "vue";
import ViewModal from "@/Components/ViewModal.vue";
import EditModal from "@/Components/EditModal.vue";
import EditBookModal from "@/Components/Books/EditBookModal.vue";
import ViewBookModal from "@/Components/Books/ViewBookModal.vue";
import { deleteConfirmation } from "@/composables/deleteConfirmation";
import Pagination from "@/Components/Pagination.vue";
import SearchInput from "@/Components/SearchInput.vue";

const toast = toastNotications();

const props = defineProps({
    categories: Object,
    required: true,
    books: Object,
       filters: Object,
});

const showAddModal = ref(false);
const showViewModal = ref(false);
const showEdit= ref(false);
const selectedBook = ref(null);

// add form modal
const addForm = useForm({
    category_id: "",
    title: "",
    author: "",
    isbn: "",
    copies: "",
});

const openAddModal = () => {
    showAddModal.value = true;
};

const closeAddModal = () => {
    showAddModal.value = false;
    addForm.reset();
};

const createBook = () => {
    addForm.post(route("books.store"), {
        onSuccess: () => {
            toast.success("Create Successfully");
            addForm.reset();
            closeAddModal();
        },
    });
};
// add form modal

const openViewModal = (book) => {
    showViewModal.value = true;
    selectedBook.value = book;
};


const openEditModal = (book) => {
    selectedBook.value = book
    showEdit.value = true
};

const deleteBook = async (book) => {
    const  confirmed = await deleteConfirmation();
    if(!confirmed) return; 

    router.delete(route('books.destroy', book), {
          onSuccess: () => {
            toast.success("Delete Successfully");
        },
        onError: () => {
            toast.error("Failed to delete");
        },
    })
}


</script>

<template>
    <Head title="Books" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Books
                </h2>

                <button
                    @click="openAddModal()"
                    class="px-2 py-1 text-white bg-indigo-600 rounded"
                >
                    New Books
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                 <SearchInput
    routeName="books.index"
    placeholder="Search book..."
    queryParam="search"
    :initialValue="filters.search"
/>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 text-gray-900">

                          
                        <!-- TABLE HERE -->
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Title</th>
                                    <th class="text-start">Author</th>
                                    <th class="text-start">ISBN</th>
                                    <th class="text-start">Copies</th>
                                    <th class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="books.data && books.data.length > 0">
                                <tr
                                    class="text-lg"
                                    v-for="book in books.data"
                                    :key="book.id"
                                >
                                    <td>{{ book.id }}</td>
                                    <td>{{ book.title }}</td>
                                    <td>{{ book.author }}</td>
                                    <td>{{ book.isbn }}</td>
                                    <td>{{ book.copies }}</td>

                                    <td class="flex my-1 space-x-2">
                                        <button
                                            @click="openViewModal(book)"
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
                                            @click="openEditModal(book)"
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
                                            @click="deleteBook(book.id)"
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
    <td colspan="100%" class="py-4 text-center text-gray-500">
      No data
    </td>
  </tr>
</tbody>
                        </table>
                        <!-- TABLE HERE -->

                          <!-- Pagination  -->
                        <Pagination :links="books.links" />

                      
                    </div>
                     
                </div>
            </div>
        </div>

        <!-- Add modal  -->
        <AddModal :show="showAddModal" @close="closeAddModal">
            <!-- Content Here -->
            <div class="p-6 space-y-4">
                 <h2 class="text-xl font-bold text-gray-900">
                                        Create Book
                                    </h2>
                <form @submit.prevent="createBook">
                    <div class="mb-5">
                        <label for="category_id" class="block mb-2 font-medium"
                            >Category title</label
                        >

                        <select
                            v-model="addForm.category_id"
                            id="category_id"
                            class="w-full border border-gray-300 rounded"
                        >
                            <option value="" disabled>Select a category</option>

                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.title }}
                            </option>
                        </select>

                        <InputError
                            :message="addForm.errors.category_id"
                            class="mt-1"
                        />
                    </div>

                    <div class="mb-5">
                        <label for="title" class="block mb-2 font-medium"
                            >Title</label
                        >
                        <input
                            v-model="addForm.title"
                            type="text"
                            id="title"
                            class="w-full border border-gray-300 rounded"
                        />
                        <InputError
                            :message="addForm.errors.title"
                            class="mt-1"
                        />
                    </div>

                    <div class="mb-5">
                        <label for="title" class="block mb-2 font-medium"
                            >Author</label
                        >
                        <input
                            v-model="addForm.author"
                            type="text"
                            id="author"
                            class="w-full border border-gray-300 rounded"
                        />
                        <InputError
                            :message="addForm.errors.author"
                            class="mt-1"
                        />
                    </div>

                    <div class="mb-5">
                        <label for="title" class="block mb-2 font-medium"
                            >ISBN</label
                        >
                        <input
                            v-model="addForm.isbn"
                            type="text"
                            maxlength="20"
                            id="isbn"
                            class="w-full border border-gray-300 rounded"
                        />
                        <InputError
                            :message="addForm.errors.isbn"
                            class="mt-1"
                        />
                    </div>

                    <div class="mb-5">
                        <label for="title" class="block mb-2 font-medium"
                            >Copies</label
                        >
                        <input
                            v-model="addForm.copies"
                            type="number"
                         
                            id="copies"
                            class="w-full border border-gray-300 rounded"
                        />
                        <InputError
                            :message="addForm.errors.copies"
                            class="mt-1"
                        />
                    </div>

                    <div class="flex justify-end mb-5">
                        <button
                            type="button"
                            @click="closeAddModal"
                            class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                        >
                            Cancel
                        </button>

                        <button
                            :disabled="addForm.processing"
                         
                            type="submit"
                            class="text-white mx-2 bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                              {{ processing ? 'Creating...' : 'Submit' }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- Content Here -->
        </AddModal>
        <!-- Add modal  -->

        <!-- View modal  -->
        <ViewBookModal 
            :show="showViewModal"
            :book="selectedBook"
            @close="showViewModal = false"
        />
        <!-- View modal  -->

        <!-- Edit modal  -->
        <EditBookModal
            :show="showEdit"
            :book="selectedBook"
            :categories="categories"
            @close="showEdit = false"
        />
        <!-- Edit modal  -->
    </AuthenticatedLayout>
</template>
