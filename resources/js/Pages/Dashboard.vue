<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage()

const categoriesCount = computed(() => page.props.categoriesCount)

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex p-6 text-gray-900">
                        <!-- You're logged in! -->

                        <Link
                            :href="route('categories.index')"
                            class="block max-w-xs p-6 m-2 bg-white border border-gray-200 rounded-lg shadow-sm"
                        >
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-black"
                            >
                                Total Categories
                            </h5>
                            <p
                                class="text-xl text-gray-700 dark:text-gray-400"
                            >
                                {{ categoriesCount  }}
                            </p>
                        </Link>

                        

                        

                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
