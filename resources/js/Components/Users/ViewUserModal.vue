<script setup>
const props = defineProps({
    show: Boolean,
    user: Object,
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
            <div class="bg-white p-6 rounded-lg shadow-lg w-[800px]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">User Details</h2>
                    <button
                        @click="emit('close')"
                        class="text-2xl text-gray-500 hover:text-gray-800"
                    >
                        &times;
                    </button>
                </div>

                <div class="space-y-2">
                    <p><strong>Name: </strong>{{ user.name }}</p>
                    <p><strong>Email: </strong> {{ user.email }}</p>

                    <table class="w-full mt-2 ">
                        <thead>
                            <tr>
                                <th class="text-start">ID</th>
                                <th class="text-start">Book</th>
                                <th class="text-start">Borrowed</th>
                                <th class="text-start">Due</th>
                                <th class="text-start">Returned</th>
                                                                <th class="text-start">Status</th>

                            </tr>
                        </thead>

                        <tbody v-if="user.borrows.length > 0">
                            <tr v-for="borrow in user.borrows" :key="borrow.id">
                                <td>{{ borrow.id }}</td>

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
                                    {{ borrow.returned_at ? 
                                        new Date(
                                            borrow.returned_at
                                        ).toLocaleDateString() : 'N/A'
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
