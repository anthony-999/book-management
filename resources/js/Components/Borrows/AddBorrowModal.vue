<script setup>
const props = defineProps({
    form: Object, // Inertia form instance
    books: Array, // For dropdown list of books
    users: Array, // For dropdown list of users
});
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
           
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40"
        >
            <div class="bg-white p-6 rounded shadow-lg w-[500px]">
                <div class="flex items-center justify-between">
                    <h2 class="mb-4 text-xl font-semibold">New Borrow</h2>
                      <button
                            type="button"
                            @click="$emit('cancel')"
                           class="text-2xl text-gray-500 hover:text-gray-800"
                        >
                              &times;
                        </button>

                 
                </div>

                <form @submit.prevent="$emit('submit')">
                    <!-- User -->
                    <div class="mb-3">
                        <label class="block">User</label>
                        <select
                            v-model="form.user_id"
                            class="w-full p-2 border rounded"
                        >
                            <option value="">-- Select User --</option>
                            <option
                                v-for="u in users"
                                :key="u.id"
                                :value="u.id"
                            >
                                {{ u.name }}
                            </option>
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
                            v-model="form.book_id"
                            class="w-full p-2 border rounded"
                        >
                            <option value="">-- Select Book --</option>
                            <option
                                v-for="b in books"
                                :key="b.id"
                                :value="b.id"
                            >
                                {{ b.title }} ({{ b.author }})
                            </option>
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

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                       
                        <button
                            type="button"
                            @click="$emit('cancel')"
                            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
                        >
                            Cancel
                        </button>

                         <button
                            type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                        >
                            Borrow
                        </button>
                        
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>
