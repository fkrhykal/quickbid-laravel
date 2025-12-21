<script setup lang="ts">
import { reactive, ref, useTemplateRef } from "vue";
import { onClickOutside } from "../utils/onClickOutside";
import { LayoutListIcon, SearchIcon } from "./icons";

defineProps<{ categories: { id: number; name: string }[] }>();

const selectedCategories = reactive<Map<number, undefined>>(new Map());

const markedCategories = (id: number) => {
    if (selectedCategories.has(id)) {
        selectedCategories.delete(id);
    } else {
        selectedCategories.set(id, undefined);
    }
};

const focus = ref(false);
const open = ref(false);
const activator = useTemplateRef<HTMLElement>("activator");

const dropdown = useTemplateRef<HTMLElement>("dropdown");

const close = () => {
    open.value = false;
};

onClickOutside(close, activator, dropdown);
</script>

<template>
    <div
        :class="{ 'ring-ring ring-4': focus }"
        class="border-border bg-surface flex size-full items-center rounded-lg border">
        <div class="relative">
            <button
                ref="activator"
                @click="open = !open"
                class="p-4 hover:bg-primary/10 rounded-l-md">
                <LayoutListIcon />
                <div>
                    <span
                        v-if="selectedCategories.size > 0"
                        class="absolute size-4 top-[10%] left-[10%] bg-primary text-surface text-xs flex items-center justify-center rounded-md">
                        {{ selectedCategories.size }}
                    </span>
                </div>
            </button>
            <div
                ref="dropdown"
                v-if="open"
                class="absolute whitespace-nowrap p-2 border border-border shadow-lg bg-raised mt-2 rounded-md">
                <ul class="space-y-1 overflow-y-auto">
                    <li
                        :class="{
                            'bg-gray-100 dark:bg-elevated':
                                selectedCategories.has(category.id),
                        }"
                        @click="markedCategories(category.id)"
                        class="p-2 flex gap-x-24 items-center justify-between rounded-sm text-primary cursor-pointer"
                        v-for="category in categories">
                        <p>
                            {{ category.name }}
                        </p>
                        <div>
                            <input
                                type="checkbox"
                                :checked="selectedCategories.has(category.id)"
                                class="ml-2 accent-primary" />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <input
            id="search"
            @focus="focus = true"
            @blur="focus = false"
            class="size-full px-2 focus:outline-none"
            type="text" />
        <div class="text-primary px-3 py-3">
            <SearchIcon />
        </div>
    </div>
</template>
