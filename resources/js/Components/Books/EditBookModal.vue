<script setup>
import BookForm from "./BookForm.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { toastNotications } from "@/composables/toastNotifications";
const toast = toastNotications();

const props = defineProps({
    show: Boolean,
    book: {
        type: Object,
        default: null,
    },
    categories: Array,
});

const emit = defineEmits(["close"]);

const form = useForm({
    category_id: "",
    title: "",
    author: "",
    isbn: "",
    copies: "",
});

// Watch for book changes → update form values
watch(
    () => props.book,
    (book) => {
        if (book) {
            form.category_id = book.category_id;
            form.title = book.title;
            form.author = book.author;
            form.isbn = book.isbn;
            form.copies = book.copies;
        }
    },
    { immediate: true } // run also when modal first opens
);

function updateBook() {
    form.put(route("books.update", props.book.id), {
        onSuccess: () => {
            toast.success("Update  Successfully");

            emit("close");
        },
        onError: () => {
            toast.error("Failed to update");
        },
    });
}
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
                    <h2 class="mb-4 text-xl font-semibold">Edit Book</h2>
                    <button
                        @click="emit('close')"
                        class="text-2xl text-gray-500 hover:text-gray-800"
                    >
                        &times;
                    </button>
                </div>

                <BookForm
                    :form="form"
                    :categories="categories"
                    @submit="updateBook"
                    @cancel="emit('close')"
                />
            </div>
        </div>
    </Transition>
</template>
