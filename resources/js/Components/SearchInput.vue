<script setup>
import { ref, watch } from "vue"           // ✅ import from Vue
import { router } from "@inertiajs/vue3"   // ✅ Inertia router


const props = defineProps({
    placeholder: {
        type: String,
        default: "Search..."
    },
    routeName: {
        type: String,
        required : true
    },
    queryParam : {
        type: String,
        default: "search"
    },
    intialValue: {
        type: String,
        default: ""
    }
})

const search = ref(props.intialValue)

// Watch search and update results
watch(search, (value) =>{
    router.get(route(props.routeName),
    // send query string ?search=... 
    {[props.queryParam] : value}, 
    {
        // keeps pagination, etc.
        preserveState: true,
        // avoid browser history clutter
        replace: true
    })
})


</script>

<template>
    <!-- Search -->
                <div class="flex justify-end my-2">
                    <input
                        v-model="search"
                        type="text"
                        :placeholder=placeholder
                        class="py-1 rounded"
                    />
                </div>
                <!-- Search -->
</template>



<style  scoped>

</style>