<script setup>
const props = defineProps({
    show: Boolean,
    borrow: Object,
    users: Object,
    books: Object,
});

const emit = defineEmits(["close"]);
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
                    <h2 class="text-xl font-semibold">Borrow Details</h2>
                    <button
                        @click="emit('close')"
                        class="text-2xl text-gray-500 hover:text-gray-800"
                    >
                        &times;
                    </button>
                </div>

                <div v-if="borrow" class="space-y-2">
                    <p><strong>User:</strong> {{ borrow.user.name }}</p>
                    <p><strong>Book:</strong> {{ borrow.book.title }}</p>
                    <p>
                        <strong>Borrowed at:</strong>
                        {{ new Date(borrow.borrowed_at).toLocaleDateString() }}
                    </p>
                    <p>
                        <strong>Due at:</strong>
                        {{ new Date(borrow.due_at).toLocaleDateString() }}
                    </p>
                    <p>
                        <strong>Return at:</strong>
                        {{ borrow.returned_at ? new Date(borrow.returned_at).toLocaleDateString() : 'N/A' }}
                    </p>
                  
                    <p>
                        <strong>Status:</strong>
                      <button
                                            class="px-1 mx-2 text-sm rounded"
                                           :class="{
    'bg-blue-500 text-white': borrow.status === 'borrowed',
    'bg-red-500 text-white': borrow.status === 'overdue',
    'bg-green-500 text-white': borrow.status === 'returned'
  }"
                                        >
                                            {{ borrow.status }}
                                        </button>
                    </p>

                   
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
