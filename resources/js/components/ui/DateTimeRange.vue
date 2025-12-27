<script setup lang="ts">
import { ref } from 'vue'
import Calender from './Calender.vue'
import TimeField from './TimeField.vue'

const open = ref(false)
</script>

<template>
    <div>
        <div @click="open = !open">{{ open }}</div>
        <div
            v-if="open"
            class="border-border relative w-fit rounded-md border p-4">
            <div class="flex items-center justify-between">
                <TimeField />
                <div>to</div>
                <TimeField />
            </div>
            <div class="mt-4 flex gap-4">
                <Calender />
            </div>
        </div>
    </div>
</template>
