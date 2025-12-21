<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import { LoaderCircleIcon } from "../../components/icons";
import { AuthLayout } from "../../components/layout";
import { Button, ErrorField, TextField } from "../../components/ui";

const form = useForm({
    username: "",
    password: "",
});
</script>

<template>
    <AuthLayout>
        <div
            class="bg-surface border-border my-4 max-h-fit w-full max-w-sm rounded-lg border p-8 shadow">
            <div>
                <h1
                    class="text-primary text-2xl font-semibold tracking-tighter">
                    Create your account
                </h1>
                <p class="text-muted-foreground mt-1 text-sm">
                    Register to start buying and selling
                </p>
            </div>
            <form
                @submit.prevent="form.post('/sign-up')"
                class="mt-10 space-y-3">
                <div class="space-y-1.5">
                    <TextField
                        id="singup-username"
                        @input="form.clearErrors('username')"
                        v-model="form.username"
                        label="Username"
                        placeholder="Enter your username" />
                    <ErrorField
                        v-if="form.errors.username"
                        :message="form.errors.username" />
                </div>
                <div class="space-y-1.5">
                    <TextField
                        id="signup-password"
                        @input="form.clearErrors('password')"
                        v-model="form.password"
                        label="Password"
                        placeholder="Enter your password" />
                    <ErrorField
                        v-if="form.errors.password"
                        :message="form.errors.password" />
                </div>
                <Button
                    :disabled="form.hasErrors || form.processing"
                    type="submit"
                    class="mt-6 grid place-items-center">
                    <LoaderCircleIcon
                        class="animate-spin size-5"
                        v-if="form.processing" />
                    <p v-else>Sign up</p>
                </Button>
            </form>
            <div class="bg-border mt-6 mb-4 h-px w-full dark:bg-none"></div>
            <p class="space-x-1 text-center text-sm">
                <span class="text-muted-foreground"
                    >Already have an account?</span
                >
                <Link
                    as="a"
                    href="/sign-in"
                    class="text-primary font-semibold hover:underline"
                    >Sign in</Link
                >
            </p>
        </div>
    </AuthLayout>
</template>
