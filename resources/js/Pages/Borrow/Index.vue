<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddBorrowModal from "@/Components/Borrows/AddBorrowModal.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { toastNotications } from "@/composables/toastNotifications";
import { deleteConfirmation } from "@/composables/deleteConfirmation";
import Pagination from "@/Components/Pagination.vue";
import ViewBorrowModal from "@/Components/Borrows/ViewBorrowModal.vue";
import EditBorrowModal from "@/Components/Borrows/EditBorrowModal.vue";
import SearchInput from "@/Components/SearchInput.vue";


const toast = toastNotications();
const showAddModal = ref(false);
const showViewModal = ref(false);
const showEditModal = ref(false);

const selectedBorrow = ref(null);

const openAddModal = () => {
    showAddModal.value = true;
};

const openViewModal = (borrow) => {
    showViewModal.value = true;
    selectedBorrow.value = borrow;
};

const openEditModal = (borrow) => {
    showEditModal.value = true;
    selectedBorrow.value = borrow;
};

const props = defineProps({
    borrows: Object,  // paginator object
    users: Array,
    books: Array,
    filters: Object,
});

console.log(props.borrows)


const borrowForm = useForm({
    user_id: "",
    book_id: "",
    borrowed_at: "",
    due_at: "",
});

const submitBorrow = () => {
    borrowForm.post(route("borrows.store"), {
        onSuccess: () => {
            toast.success("Create Successfully");
            borrowForm.reset();
            showAddModal.value = false;
        },
    });
};

const deleteBorrow = async (borrow) => {
    const confirmed = await deleteConfirmation();

    if (!confirmed) return;

    router.delete(route("borrows.destroy", borrow), {
        onSuccess: () => {
            toast.success("Delete Successfully");
        },
        onError: () => {
            toast.error("Failed to delete");
        },
    });
};
</script>

<template>
    <Head title="Borrow" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Borrows
                </h2>

                <button
                    @click="openAddModal()"
                    class="px-2 py-1 text-white bg-indigo-600 rounded"
                >
                    New Borrow
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <SearchInput
                    routeName="borrows.index"
                    placeholder="Search user..."
                    queryParam="search"
                    :initialValue="filters.search"
                />
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 ">
                        <!-- TABLE HERE -->
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Users</th>
                                    <th class="text-start">Book</th>
                                    <th class="text-start">Borrowed Date</th>
                                    <th class="text-start">Due Date</th>
                                    <th class="text-start">Return Date</th>

                                    <th class="text-start">Status</th>

                                    <th class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody
                                v-if="borrows.data && borrows.data.length > 0"
                            >
                                <tr
                                    class="text-lg"
                              v-for="borrow in borrows.data" :key="borrow.id"
                                >
                                    <td>{{ borrow.id }}</td>
                                    <td>{{ borrow.user.name }}</td>
                                    <td>{{ borrow.book.title }}</td>
                                    <td>
                                        {{
                                            new Date(
                                                borrow.borrowed_at
                                            ).toLocaleDateString()
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            new Date(
                                                borrow.due_at
                                            ).toLocaleDateString()
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            borrow.returned_at
                                                ? new Date(
                                                      borrow.returned_at
                                                  ).toLocaleDateString()
                                                : "N/A"
                                        }}
                                    </td>
                                    <td>
                                        <button
                                            class="px-1 text-sm rounded"
                                            :class="{
                                                'bg-blue-500 text-white':
                                                    borrow.status ===
                                                    'borrowed',
                                                'bg-red-500 text-white':
                                                    borrow.status === 'overdue',
                                                'bg-green-500 text-white':
                                                    borrow.status ===
                                                    'returned',
                                            }"
                                        >
                                            {{ borrow.status }}
                                        </button>
                                    </td>

                                    <td class="flex my-1 space-x-2">
                                        <button
                                            @click="openViewModal(borrow)"
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
                                            @click="openEditModal(borrow)"
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
                                            @click="deleteBorrow(borrow.id)"
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
                    </div>
                    <!-- Pagination  -->
                    <Pagination :links="borrows.links" />
                </div>
            </div>
        </div>

        <ViewBorrowModal
            :show="showViewModal"
            :borrow="selectedBorrow"
            :users="users"
            :books="books"
            @close="showViewModal = false"
        />

        <EditBorrowModal
            :show="showEditModal"
            :borrow="selectedBorrow"
            :user="users"
            :book="books"
            @close="showEditModal = false"
        />

        <AddBorrowModal
            v-if="showAddModal"
            :form="borrowForm"
            :books="props.books"
            :users="props.users"
            @submit="submitBorrow"
            @cancel="showAddModal = false"
        />
    </AuthenticatedLayout>
</template>
