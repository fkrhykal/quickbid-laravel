<script setup lang="ts">
import { CircleAlertIcon } from "../icons";

defineProps<{ message: string }>();
</script>

<template>
    <div
        class="flex w-fit gap-x-1 rounded-md border border-red-200 bg-red-50 px-1.5 py-1 text-[0.75rem] text-red-500 dark:border-gray-500 dark:text-white dark:bg-gray-800"
    >
        <div class="mt-0.5">
            <CircleAlertIcon class="size-3.5" />
        </div>
        <p>
            {{ message }}
        </p>
    </div>
</template>
