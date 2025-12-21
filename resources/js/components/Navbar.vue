<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { useAuth } from '../utils/useAuth'
import { Logo } from './icons'
import Profile from './Profile.vue'
import { Button } from './ui'

const user = useAuth()
</script>

<template>
    <header
        className="sticky top-0 z-50 justify-between py-2 w-full border-b border-border bg-surface/90 backdrop-blur">
        <div
            class="container mx-auto flex items-center justify-between px-4 lg:px-0">
            <div>
                <Logo />
            </div>
            <div class="flex items-center">
                <div
                    v-if="user"
                    class="flex gap-x-6">
                    <Profile />
                </div>
                <Link
                    v-else
                    href="/sign-in"
                    class="size-min">
                    <Button
                        type="button"
                        class="whitespace-nowrap">
                        Sign in
                    </Button>
                </Link>
            </div>
        </div>
    </header>
</template>
