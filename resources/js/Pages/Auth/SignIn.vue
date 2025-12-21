<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import { AuthLayout } from '../../components/layout'
import { Button, TextField } from '../../components/ui'
import ErrorField from '../../components/ui/ErrorField.vue'

type Error = typeof form.errors & { auth?: string }

const form = useForm({
    username: '',
    password: '',
    rememberMe: false,
})

const errors = computed(() => form.errors as Error)

const clearError = (key: keyof Error) => {
    errors.value[key] = undefined
}
</script>

<template>
    <AuthLayout>
        <div
            class="bg-surface border-border my-4 max-h-fit w-full max-w-sm rounded-lg border p-8 shadow">
            <div>
                <h1
                    class="text-primary text-2xl font-semibold tracking-tighter">
                    Welcome back
                </h1>
                <p class="text-muted-foreground mt-1 text-sm">
                    Sign in to your account to continue
                </p>
            </div>

            <form
                @submit.prevent="form.post('/sign-in')"
                class="mt-10 space-y-3">
                <TextField
                    id="singin-username"
                    @input="clearError('auth')"
                    v-model="form.username"
                    label="Username"
                    placeholder="Enter your username" />
                <TextField
                    id="signin-password"
                    @input="clearError('auth')"
                    v-model="form.password"
                    label="Password"
                    placeholder="Enter your password" />
                <div class="flex gap-x-2">
                    <input
                        v-model="form.rememberMe"
                        type="checkbox"
                        class="accent-primary" />
                    <p class="text-sm text-muted-foreground tracking-tight">
                        Remember me?
                    </p>
                </div>
                <div>
                    <ErrorField
                        v-if="errors.auth"
                        :message="errors.auth" />
                </div>
                <Button
                    type="submit"
                    class="mt-6"
                    >Sign in</Button
                >
            </form>
            <div class="bg-border mt-6 mb-4 h-px w-full dark:bg-none"></div>
            <p class="space-x-1 text-center text-sm">
                <span>Don't have an acount?</span>
                <Link
                    as="a"
                    class="font-semibold hover:underline"
                    href="/sign-up"
                    >Sign up</Link
                >
            </p>
        </div>
    </AuthLayout>
</template>
