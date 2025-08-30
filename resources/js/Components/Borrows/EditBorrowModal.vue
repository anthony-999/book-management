<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { toastNotications } from "@/composables/toastNotifications";
const toast = toastNotications();

const props = defineProps({
    show: Boolean,
    form: Object, // Inertia form instance
    borrow: Object,
    book: Array, // For dropdown list of books
    user: Array, // For dropdown list of users
});

const emit = defineEmits(["close"]);

// editing form v-model
const form = useForm({
    user_id: "",
    book_id: "",
    borrowed_at: "",
    due_at: "",
    returned_at: "",
});

// Watch for book changes → update form values
watch(
    () => props.borrow,
    (borrow) => {
        if (borrow) {
            form.user_id = borrow.user_id;
            form.book_id = borrow.book_id;
            form.borrowed_at = borrow.borrowed_at;
            form.due_at = borrow.due_at;
            form.returned_at = borrow.returned_at;
        }
    },
    { immediate: true } // run also when modal first opens
);

const submit = () => {
    form.put(route("borrows.update", props.borrow.id), {
         onSuccess: () => {
            toast.success("Update  Successfully");

            emit("close");
        },
        onError: () => {
            toast.error("Failed to update");
        },
    });
};
</script>

<template>
    <Transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="show"
            @click="close"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40"
        >
            <div class="bg-white p-6 rounded shadow-lg w-[500px]">
                <div class="flex items-center justify-between">
                    <h2 class="mb-4 text-xl font-semibold">Edit Borrow</h2>

                    <button
                        @click="emit('close')"
                        class="text-2xl text-gray-500 hover:text-gray-800"
                    >
                        &times;
                    </button>
                </div>

                <form @submit.prevent="submit">
                    <!-- User -->
                    <div class="mb-3">
                        <label class="block">User</label>
                        <select
                            v-model="form.user_id"
                            disabled
                            class="w-full p-2 border rounded"
                        >
                            <option :value="borrow.user_id">{{borrow.user.name}}</option>
                           
                        </select>
                        <div
                            v-if="form.errors.user_id"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.user_id }}
                        </div>
                    </div>

                    <!-- Book -->
                    <div class="mb-3">
                        <label class="block">Book</label>
                        <select
                            disabled
                            v-model="form.book_id"
                            class="w-full p-2 border rounded"
                        >
                            <option :value="borrow.book_id">{{borrow.book.title}}</option>
                           
                        </select>
                        <div
                            v-if="form.errors.book_id"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.book_id }}
                        </div>
                    </div>

                    <!-- Borrowed At -->
                    <div class="mb-3">
                        <label class="block">Borrowed At</label>
                        <input
                            type="date"
                            v-model="form.borrowed_at"
                            class="w-full p-2 border rounded"
                        />
                        <div
                            v-if="form.errors.borrowed_at"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.borrowed_at }}
                        </div>
                    </div>

                    <!-- Due At -->
                    <div class="mb-3">
                        <label class="block">Due At</label>
                        <input
                            type="date"
                            v-model="form.due_at"
                            class="w-full p-2 border rounded"
                        />
                        <div
                            v-if="form.errors.due_at"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.due_at }}
                        </div>
                    </div>

                    <!-- Returned At -->
                    <div class="mb-3">
                        <label class="block">Returned At</label>
                        <input
                            type="date"
                            v-model="form.returned_at"
                            class="w-full p-2 border rounded"
                        />
                        <div
                            v-if="form.errors.returned_at"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.returned_at }}
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="emit('close')"
                            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>
