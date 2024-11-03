<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Comments from "@/Components/Comments.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm, Head} from "@inertiajs/vue3";

defineProps(['comments']);

const form = useForm({
    message: '',
});

</script>

<template>
    <Head title="Comments"/>

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('comments.store'), { onSuccess: () => form.reset() })">
                <textarea v-model="form.message" placeholder="Please leave a comment"
                          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2"/>
                <PrimaryButton class="mt-4">Comment</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Comments v-for="comment in comments" :key="comment.id" :comment="comment"/>
            </div>

        </div>

    </AuthenticatedLayout>

</template>
