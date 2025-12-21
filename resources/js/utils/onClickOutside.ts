import { onMounted, onUnmounted, Ref } from 'vue'

export function onClickOutside(
    handler: () => void,
    ...elements: Ref<Node | null>[]
) {
    const onClick = (e: PointerEvent) => {
        if (e.target instanceof Node) {
            const isContain = elements.some((included) => {
                if (e.target instanceof Node && included.value) {
                    return included.value.contains(e.target)
                }
                return false
            })
            if (!isContain) {
                handler()
            }
        }
    }
    onMounted(() => {
        window.addEventListener('click', onClick)
    })
    onUnmounted(() => {
        window.removeEventListener('click', onClick)
    })
}
