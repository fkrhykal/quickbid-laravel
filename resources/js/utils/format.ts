export function px(n: number) {
    return `${n}px` as const
}

export function numPadStart(n: number, maxLength = 2, fillString = '0') {
    return n.toString().padStart(maxLength, fillString)
}
