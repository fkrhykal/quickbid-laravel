<script setup lang="ts">
import { Navbar, Search } from '../components'

defineProps<{ categories: { id: number; name: string }[] }>()
</script>

<template>
    <Navbar />
    <main class="container mx-auto px-4 lg:px-0 mt-4">
        <Search :categories />
    </main>
</template>
