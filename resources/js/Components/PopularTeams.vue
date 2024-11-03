<script setup>
const teams = [
    {id: 1, name: 'Liverpool', logo: '/path/to/liverpool-logo.png', league: 'Premier League'},
    {id: 2, name: 'Real Madrid', logo: '/path/to/real-madrid-logo.png', league: 'La Liga'},
    {id: 3, name: 'Barcelona', logo: '/path/to/barcelona-logo.png', league: 'La Liga'},
];
</script>

<template>

    <section class="p-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Popular Teams</h2>
        <div class="grid grid-cols-3 gap-4">
            <div v-for="team in teams" :key="team.id" class="bg-white shadow-md p-4 rounded-lg">
                <img :src="team.logo" alt="Team Logo" class="h-16 w-16 mx-auto"/>
                <h3 class="text-xl font-semibold mt-4">{{ team.name }}</h3>
                <p class="text-gray-500">{{ team.league }}</p>
            </div>
        </div>
    </section>
</template>
