<script setup>
const props = defineProps({
    form: Object, // Inertia form instance (useForm)
    categories: Array, // For dropdown
});
</script>

<template>
    <form @submit.prevent="$emit('submit')">
        <!-- Category -->
        <div class="mb-3">
            <label class="block">Category</label>
            <select
                v-model="form.category_id"
                class="w-full p-2 border rounded"
            >
                <option value="">-- Select Category --</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.title }}
                </option>
            </select>
            <div v-if="form.errors.category_id" class="text-sm text-red-500">
                {{ form.errors.category_id }}
            </div>
        </div>

        <!-- Title -->
        <div class="mb-3">
            <label class="block">Title</label>
            <input
                v-model="form.title"
                type="text"
                class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.title" class="text-sm text-red-500">
                {{ form.errors.title }}
            </div>
        </div>

        <!-- Author -->
        <div class="mb-3">
            <label class="block">Author</label>
            <input
                v-model="form.author"
                type="text"
                class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.author" class="text-sm text-red-500">
                {{ form.errors.author }}
            </div>
        </div>

        <!-- ISBN -->
        <div class="mb-3">
            <label class="block">ISBN</label>
            <input
                v-model="form.isbn"
                type="text"
                min="1"
                max="10"
                class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.isbn" class="text-sm text-red-500">
                {{ form.errors.isbn }}
            </div>
        </div>

        <!-- Copies -->
        <div class="mb-3">
            <label class="block">Copies</label>
            <input
                v-model="form.copies"
                type="number"
                class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.copies" class="text-sm text-red-500">
                {{ form.errors.copies }}
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2">
<!--           
            <button
                type="button"
                @click="$emit('cancel')"
                class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
            >
                Cancel
            </button> -->

              <button
                type="submit"
                :disabled="form.processing"
                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 disabled:opacity-50"
            >
                {{ form.processing ? "Saving..." : "Save" }}
            </button>
            
        </div>
    </form>
</template>
