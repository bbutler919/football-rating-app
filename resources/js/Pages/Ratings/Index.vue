<script setup>
import {ref} from "vue";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

//dummy data to be replaced with real data

const team = ref({
    name: 'Liverpool',
    logo: '',
    league: 'Premier League'
});

const players = ref([
    {
        id: 1,
        name: 'Mohamed Saleh',
        position: 'Forward',
        number: 11,
        photo: '',
        averageRating: 8.5,
        comments: [
            {id: 1, user: {name: 'John'}, message: 'Great performance!'},
            {id: 2, user: {name: 'Alice'}, message: 'Could have done better.'}
        ]
    },
]);

const showRatingModal = ref(false);
const currentPlayer = ref(null);
const ratingForm = ref({
    rating: '',
    comment: ''
});

const openRatingModal = (player) => {
    currentPlayer.value = player;
    showRatingModal.value = true;
    ratingForm.value = {rating: '', comment: ''};
};

const closeRatingModal = () => {
    showRatingModal.value = false;
};

const submitRating = () => {
    console.log('Submitting rating:', ratingForm.value)

    closeRatingModal();
};
</script>


<template>
    <Head title="Ratings"/>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto p-4">
            <img :src="team.logo" alt="Team Logo" class="h-16 w-16 object-cover"/>
            <div>
                <h1 class="text-2xl font-bold">{{ team.name }}</h1>
                <p class="text-gray-500">{{ team.league }}</p>
            </div>
        </div>

        <div v-for="player in players" :key="player.id" class="bg-white p-4 mb-4 shadow rounded-md">
            <div class="flex items-center space-x-4">
                <img :src="player.photo" alt="Player Photo" class="h-12 w-12 rounded-full object-cover"/>
                <div class="flex-1">
                    <h2 class="text-lg font-semibold">{{ player.name }} (#{{ player.number }})</h2>
                    <p class="text-gray-600">{{ player.position }}</p>
                    <p class="mt-1 text-sm">Rating: <span class="font-bold">{{ player.averageRating }}</span></p>
                </div>
                <button @click="openRatingModal(player)" class="bg-blue-500 text-white px-4 py-4 rounded-md">Rate
                </button>
            </div>

            <div class="mt-4">
                <h3 class="text-sm font-semibold">Comments</h3>
                <ul>
                    <li v-for="comment in player.comments" :key="comment.id" class="mt-2 text-gray-700">
                        <span class="font-medium">{{ comment.user.name }}</span> {{ comment.message }}
                    </li>
                </ul>
            </div>
        </div>

        <div v-if="showRatingModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Rate {{ currentPlayer.value?.name }}</h3>
                <form @submit.prevent="submitRating">
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-10)</label>
                        <input v-model="ratingForm.rating" type="number" min="1" max="10" id="rating"
                               class="mt-1 block w-full border-gray -300 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea v-model="ratingForm.comment" id="comment"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeRatingModal" class="bg-gray-300 px-4 py-2 rounded-md">Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                    </div>
                </form>
            </div>

        </div>

    </AuthenticatedLayout>
</template>
