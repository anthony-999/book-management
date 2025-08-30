<script setup>
import { useForm } from "@inertiajs/vue3";
import { toastNotications } from "@/composables/toastNotifications";

const toast = toastNotications();

const props = defineProps({
    show: Boolean,
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const emit = defineEmits(["cancel"]);


const submit = () => {
    form.post(route("users.store"), {
        onSuccess: () => {
            toast.success("Create Successfully");
            form.reset();
                  emit("cancel"); // close modal

        },
    });
};
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
      <!-- Modal Box -->
      <div class="bg-white p-6 rounded shadow-lg w-[500px]">
        <div class="flex items-center justify-between">
          <h2 class="mb-4 text-xl font-semibold">New User</h2>
          <button
            type="button"
            @click="$emit('cancel')"
            class="text-2xl text-gray-500 hover:text-gray-800"
          >
            &times;
          </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit">
          <!-- Name -->
          <div class="mb-3">
            <label class="block">Name</label>
            <input
              type="text"
              v-model="form.name"
              class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.name" class="text-sm text-red-500">
              {{ form.errors.name }}
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="block">Email</label>
            <input
              type="email"
              v-model="form.email"
              class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.email" class="text-sm text-red-500">
              {{ form.errors.email }}
            </div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="block">Password</label>
            <input
              type="password"
              v-model="form.password"
              class="w-full p-2 border rounded"
            />
            <div v-if="form.errors.password" class="text-sm text-red-500">
              {{ form.errors.password }}
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label class="block">Confirm Password</label>
            <input
              type="password"
              v-model="form.password_confirmation"
              class="w-full p-2 border rounded"
            />
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
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </Transition>
</template>