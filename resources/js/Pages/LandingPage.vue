<script setup>
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import HeroSection from "@/Components/HeroSection.vue";
import FeatureSection from "@/Components/FeatureSection.vue";
import PopularTeams from "@/Components/PopularTeams.vue";
import Footer from "@/Components/Footer.vue";
import TodayMatches from "@/Components/TodayMatches.vue";
import {ref, onMounted, onBeforeUnmount} from "vue";

const currentTime = ref(new Date().toLocaleString());

let intervalId;
const updateTime = () => {
    intervalId = setInterval(() => {
        currentTime.value = new Date().toLocaleString();
    }, 1000);
};

onMounted(() => {
    updateTime();
});

onBeforeUnmount(() => {
    clearInterval(intervalId);
});
</script>

<template>
    <Head title="Home" />
    <div class="landing-page">
        <p class="text-gray-600 mb-4">Current Date and Time {{ currentTime }}</p>
        <Header />
        <HeroSection />
        <TodayMatches />
        <FeatureSection />
        <PopularTeams />
        <Footer />

    </div>
</template>

<style scoped>
.landing-page {
    padding: 1rem;
    background-color: #f9f9f9;
    border-radius: 8px;
}
</style>
