<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
        required: true,
    }
})
</script>

<template>
    <hr>
    <div v-if="links.length > 3" class="flex flex-wrap justify-end gap-2 mt-4">
        <template v-for="link in links" :key="link.label">
            <div v-if="!link.url" v-html="link.label" class="px-3 py-1 text-gray-400 border rounded"></div>
            <Link
                v-else
                :href="link.url"
                v-html="link.label"
                class="px-3 py-1 border rounded hover:bg-gray-200"
                :class="{ 'bg-indigo-600 text-white': link.active }"
            />
        </template>
    </div>
</template>
