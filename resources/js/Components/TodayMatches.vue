<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const matches = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const totalPages = ref(1);
const perPage = ref(10); // Number of items per page

const fetchTodaysMatches = async (page = 1) => {
    loading.value = true;
    try {
        const response = await axios.get('http://localhost/todays-matches', {
            params: {
                date: new Date().toISOString().split('T')[0],
                page: page,
                per_page: perPage.value
            }
        });
        console.log("API Response:", response.data); // Debugging line to check the response structure

        if (response.data?.data && response.data?.meta) {
            matches.value = response.data.data;
            totalPages.value = response.data.meta.total_pages;
            currentPage.value = response.data.meta.current_page;
        } else {
            console.warn("Unexpected response format", response.data);
            matches.value = []; // Clear matches if the response format is not as expected
        }
    } catch (error) {
        console.error('Error fetching matches:', error);
        if (error.response) {
            if (error.response.status === 403) {
                alert('Access to the API is forbidden. Please check your API key and subscription.');
            } else if (error.response.status === 429) {
                alert('Rate limit exceeded. Please try again later.');
            } else {
                alert('An error occurred while fetching data.');
            }
        }
        matches.value = []; // Clear matches if an error occurs
    } finally {
        loading.value = false;
    }
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

const goToNextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value += 1;
        fetchTodaysMatches(currentPage.value);
    }
};

const goToPreviousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value -= 1;
        fetchTodaysMatches(currentPage.value);
    }
};

onMounted(() => {
    fetchTodaysMatches();
});
</script>

<template>
    <div class="matches">
        <h2 class="text-xl font-bold mb-4">Today's Football Matches</h2>
        <div v-if="loading" class="text-gray-600">Loading...</div>
        <div v-else>
            <ul v-if="matches.length > 0">
                <li v-for="match in matches" :key="match.fixture?.id" class="mb-4 border-b pb-2">
                    <div class="flex justify-between">
                        <span>{{ match.teams?.home?.name }} vs {{ match.teams?.away?.name }}</span>
                        <span>{{ formatTime(match.fixture?.date) }}</span>
                    </div>
                </li>
            </ul>
            <p v-else class="text-gray-600">No Matches Today</p>

            <!-- Pagination Controls -->
            <div class="pagination-controls mt-4 flex justify-between">
                <button
                    @click="goToPreviousPage"
                    :disabled="currentPage === 1"
                    class="bg-teal-400 text-white px-4 py-2 rounded disabled:bg-gray-400 hover:bg-teal-600">
                    Previous
                </button>
                <span>Page {{ currentPage }} of {{ totalPages }}</span>
                <button
                    @click="goToNextPage"
                    :disabled="currentPage === totalPages"
                    class="bg-teal-400 text-white px-4 py-2 rounded disabled:bg-gray-400 hover:bg-teal-600">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.matches {
    padding: 1rem;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.pagination-controls button:disabled {
    cursor: not-allowed;
}
</style>
