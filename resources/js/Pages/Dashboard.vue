<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const {props} = usePage()



</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="flex py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex p-6 text-gray-900">
                        <!-- You're logged in! -->

                        <Link
                            :href="route('categories.index')"
                            class="block w-64 p-6 m-2 bg-blue-500 border border-gray-200 rounded-lg shadow-sm"
                        >
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-white"
                            >
                                Total Categories
                            </h5>
                            <p
                                class="text-2xl text-white"
                            >
                                {{ props.categoriesCount  }}
                            </p>
                        </Link>

                             <Link
                            :href="route('books.index')"
                            class="block w-64 p-6 m-2 bg-blue-500 border border-gray-200 rounded-lg shadow-sm"
                        >
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-white"
                            >
                                Total Books
                            </h5>
                            <p
                                class="text-2xl text-white"
                            >
                              {{ props.booksCount }}
                            </p>
                        </Link>

                        
                             <Link
                            :href="route('borrows.index')"
                            class="block w-64 p-6 m-2 bg-blue-500 border border-gray-200 rounded-lg shadow-sm"
                        >
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-white"
                            >
                                Total Borrows
                            </h5>
                            <p
                                class="text-2xl text-white"
                            >
                              {{ props.borrowsCount }}
                            </p>
                        </Link>


                         
                             <Link
                            :href="route('users.index')"
                            class="block w-64 p-6 m-2 bg-blue-500 border border-gray-200 rounded-lg shadow-sm"
                        >
                            <h5
                                class="mb-2 text-2xl font-bold tracking-tight text-white"
                            >
                                Total Users
                            </h5>
                            <p
                                class="text-2xl text-white"
                            >
                              {{ props.usersCount }}
                            </p>
                        </Link>


                             




                        

                        

                        
                    </div>

                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
