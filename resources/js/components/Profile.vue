<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref, useTemplateRef } from 'vue'
import { onClickOutside } from '../utils/onClickOutside'
import { UserIcon } from './icons'
import LayersPlusIcon from './icons/LayersPlusIcon.vue'
import LogOutIcon from './icons/LogOutIcon.vue'

const showMenu = ref(false)

const el = useTemplateRef<HTMLElement>('el')
const included = useTemplateRef<HTMLElement>('included')
const handleClickOutside = () => (showMenu.value = false)

onClickOutside(handleClickOutside, el, included)
</script>

<template>
    <div class="relative">
        <button
            ref="included"
            @click="showMenu = !showMenu"
            class="border border-tertiary p-2 rounded-full">
            <UserIcon />
        </button>
        <Transition>
            <div
                ref="el"
                v-if="showMenu"
                class="absolute w-screen max-w-48 bg-surface border border-border shadow right-0 mt-1 rounded-md whitespace-nowrap overflow-x-hidden overflow-y-auto">
                <div class="m-2">
                    <Link
                        :class="[
                            $page.url === '/place-auction'
                                ? 'bg-tertiary/10 cursor-default'
                                : 'cursor-pointer',
                        ]"
                        href="/place-auction"
                        class="p-1 flex hover:bg-tertiary/10 items-center gap-x-2 w-full text-sm text-primary rounded-md bg-elevated">
                        <div class="p-1 rounded-md bg-tertiary/20">
                            <LayersPlusIcon class="size-4" />
                        </div>
                        <p>Place Auction</p>
                    </Link>
                </div>

                <div class="h-px w-full bg-border"></div>

                <div class="m-2">
                    <Link
                        href="/sign-out"
                        method="post"
                        class="p-1 flex items-center gap-x-2 cursor-pointer w-full text-sm text-red-900 rounded-md bg-red-50 border hover:bg-red-200/50 border-red-100">
                        <div class="bg-red-200 p-1 rounded-md">
                            <LogOutIcon class="size-4" />
                        </div>
                        <p>Sign out</p>
                    </Link>
                </div>
            </div>
        </Transition>
    </div>
</template>
