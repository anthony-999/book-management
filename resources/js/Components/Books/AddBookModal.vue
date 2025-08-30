<script setup>
import BookForm from "./BookForm.vue"
import { useForm } from "@inertiajs/vue3"
import { toastNotications } from '@/composables/toastNotifications'
const toast = toastNotications();

const props = defineProps({
  show: Boolean,
  categories: Array,
})

const emit = defineEmits(["close"])

const form = useForm({
  category_id: "",
  title: "",
  author: "",
  isbn: "",
  copies: "",
})

function createBook() {
  form.post(route("books.store"), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Book created successfully ✅")
      form.reset()
      emit("close")
    },
    onError: (errors) => {
      // Don't close/reset modal, just show inline errors
      if (errors.isbn) {
        toast.error(errors.isbn[0]) // 👉 will show "The isbn has already been taken."
      } else {
        toast.error("Please fix the highlighted errors.")
      }
    },
  })
}
</script>

<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg w-[500px]">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Add Book</h2>
        <button @click="emit('close')" class="text-gray-500 hover:text-gray-800">&times;</button>
      </div>

      <!-- Reusable BookForm -->
      <BookForm
        :form="form"
        :categories="categories"
        @submit="createBook"
        @cancel="emit('close')"
      />
    </div>
  </div>
</template>
