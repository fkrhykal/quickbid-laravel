import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

type User = {
    username: string
}

export function useAuth() {
    const page = usePage<{ user: User | null }>()
    const user = computed(() => page.props.user)
    return user
}
