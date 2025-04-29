<template>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center justify-content-md-end mb-0">
            <!-- Previous Page Link -->
            <li class="page-item" :class="{ 'disabled': page <= 1 }">
                <a 
                    class="page-link" 
                    href="javascript:;" 
                    aria-label="Previous"
                    @click="page > 1 && $emit('onPageClick', page - 1)"
                >
                    <i class="fas fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <!-- Page Numbers Logic -->
            <template v-if="pageCount <= maxVisibleTotal">
                <!-- Show all pages when total is small -->
                <li 
                    v-for="n in pageCount" 
                    :key="n"
                    class="page-item"
                    :class="{ 'active': n === page }"
                >
                    <a 
                        class="page-link" 
                        href="javascript:;" 
                        @click="$emit('onPageClick', n)"
                    >
                        {{ n }}
                    </a>
                </li>
            </template>
            
            <template v-else>
                <!-- First Page -->
                <li 
                    class="page-item" 
                    :class="{ 'active': page === 1 }"
                >
                    <a 
                        class="page-link" 
                        href="javascript:;" 
                        @click="$emit('onPageClick', 1)"
                    >
                        1
                    </a>
                </li>
                
                <!-- Ellipsis before middle pages -->
                <li class="page-item disabled" v-if="startPage > 2">
                    <span class="page-link">...</span>
                </li>

                <!-- Middle Pages -->
                <li 
                    v-for="n in middlePages" 
                    :key="n"
                    class="page-item" 
                    :class="{ 'active': n === page }"
                >
                    <a 
                        class="page-link" 
                        href="javascript:;" 
                        @click="$emit('onPageClick', n)"
                    >
                        {{ n }}
                    </a>
                </li>

                <!-- Ellipsis after middle pages -->
                <li class="page-item disabled" v-if="endPage < pageCount - 1">
                    <span class="page-link">...</span>
                </li>

                <!-- Last Page (if not already included) -->
                <li 
                    v-if="pageCount > 1"
                    class="page-item" 
                    :class="{ 'active': page === pageCount }"
                >
                    <a 
                        class="page-link" 
                        href="javascript:;" 
                        @click="$emit('onPageClick', pageCount)"
                    >
                        {{ pageCount }}
                    </a>
                </li>
            </template>

            <!-- Next Page Link -->
            <li class="page-item" :class="{ 'disabled': page >= pageCount }">
                <a 
                    class="page-link" 
                    href="javascript:;" 
                    aria-label="Next"
                    @click="page < pageCount && $emit('onPageClick', page + 1)"
                >
                    <i class="fas fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        page: {
            type: Number,
            required: true,
            validator: value => value >= 1
        },
        total: {
            type: Number,
            required: true,
            validator: value => value >= 0
        },
        per_page: {
            type: Number,
            required: true,
            validator: value => value >= 1
        },
        maxVisible: {
            type: Number,
            default: 5,
            validator: value => value >= 3
        }
    },
    computed: {
        pageCount() {
            return Math.max(1, Math.ceil(this.total / this.per_page));
        },
        
        // Total pages to display (including first, last, and ellipses)
        maxVisibleTotal() {
            return this.maxVisible + 2; // +2 for first and last page
        },
        
        // Calculate start and end pages for middle section
        startPage() {
            // Always reserve space for first and last page and at least one middle page
            const effectiveMaxVisible = this.maxVisible - 2;
            const halfVisible = Math.floor(effectiveMaxVisible / 2);
            
            if (this.page <= halfVisible + 1) {
                // Near beginning, show first pages
                return 2;
            } else if (this.page >= this.pageCount - halfVisible) {
                // Near end, show last pages
                return Math.max(2, this.pageCount - effectiveMaxVisible);
            } else {
                // In middle, center current page
                return this.page - halfVisible;
            }
        },
        
        endPage() {
            const availablePages = Math.min(this.maxVisible - 2, this.pageCount - 2);
            return Math.min(this.startPage + availablePages - 1, this.pageCount - 1);
        },
        
        middlePages() {
            if (this.pageCount <= 2) {
                return [];
            }
            
            const pages = [];
            for (let i = this.startPage; i <= this.endPage; i++) {
                pages.push(i);
            }
            return pages;
        }
    }
};
</script>

<style scoped>
.pagination {
    display: flex;
    flex-wrap: wrap;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    min-width: 40px;
    text-align: center;
    color: #6c757d;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    z-index: 1;
}

.page-link:hover:not(.disabled) {
    background-color: #e9ecef;
    color: #0056b3;
    z-index: 2;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.6;
}

@media (max-width: 576px) {
    .page-link {
        min-width: 36px;
        padding: 0.4rem 0.6rem;
    }
}
</style>