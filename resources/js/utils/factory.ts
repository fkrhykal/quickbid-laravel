import type { AuctionItem } from '@/components/AuctionItemForm.vue'

export function defaultAuctionItem(): AuctionItem {
    return {
        name: '',
        description: '',
        pictures: [],
        price: 0,
    }
}

export function defaultAuctionItems(length: number): AuctionItem[] {
    return Array(length).fill(defaultAuctionItem())
}
