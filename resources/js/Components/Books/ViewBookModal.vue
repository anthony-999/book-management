<script setup>
const props = defineProps({
    show: Boolean,
    book: Object,
})

const emit = defineEmits(['close'])

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
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg w-[500px]">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Book Details</h2>
        <button @click="emit('close')" class="text-2xl text-gray-500 hover:text-gray-800">&times;</button>
      </div>

      <div v-if="book" class="space-y-2">
        <p><strong>Category:</strong> {{ book.category?.title }}</p>
        <p><strong>Title:</strong> {{ book.title }}</p>
        <p><strong>Author:</strong> {{ book.author }}</p>
        <p><strong>ISBN:</strong> {{ book.isbn }}</p>
        <p><strong>Copies:</strong> {{ book.copies }}</p>
      </div>

      <div class="flex justify-end mt-6">
        <button
          @click="emit('close')"
          class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
        >
          Close
        </button>
      </div>
    </div>
  </div>
      </Transition>
</template>
