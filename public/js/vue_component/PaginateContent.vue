<template>
    <nav>
        <ul class="pagination justify-content-end">
            <li
                @click="page != 1 && $emit('onPageClick', page - 1)"
                :class="`page-item ${
                    page == 1 ? 'disabled' : 'cursor-pointer'
                }`"
            >
                <a class="page-link" tabindex="-1">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li
                v-for="(item, index) in paginateItem"
                :key="index"
                :class="`page-item cursor-pointer ${
                    item == page ? 'active' : ''
                }`"
                @click="$emit('onPageClick', item)"
            >
                <span
                    :class="`page-link ${item == page ? 'text-white' : ''}`"
                    >{{ item }}</span
                >
            </li>
            <li
                @click="page != pageCount && $emit('onPageClick', page + 1)"
                :class="`page-item ${
                    page == pageCount ? 'disabled' : 'cursor-pointer'
                }`"
            >
                <a class="page-link" href="javascript:;">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    props: ["page", "total", "per_page"],
    computed: {
        pageCount() {
            return Math.ceil(this.total / this.per_page);
        },
        paginateItem() {
            if(this.pageCount == 0) {
                return [1]
            }
            const maxLength = 12;
            const leftWidth = 2;
            const maxleftWidth = 3;
            const rightWidth = 2;
            const maxRightWidth = 3;
            const page = 27;
            function range(start, end) {
                if (start == end) {
                    return [start];
                } else if (end > start) {
                    var ans = [];
                    for (let i = start; i <= end; i++) {
                        ans.push(i);
                    }
                    return ans;
                } else {
                    var ans = [];
                    for (let i = start; i >= end; i--) {
                        ans.unshift(i);
                    }
                    return ans;
                }
            }
            if (this.pageCount <= maxLength) {
                return range(1, this.pageCount);
            }

            var centerWidth = maxLength - leftWidth - rightWidth;

            const rightContents = range(
                1,
                page <= maxleftWidth ? maxleftWidth : leftWidth
            );
            const leftContents = range(
                this.pageCount,
                page >= this.pageCount - (maxRightWidth - 1)
                    ? this.pageCount - (maxRightWidth - 1)
                    : this.pageCount - (rightWidth - 1)
            );
            let centerContents =
                rightContents.includes(page) || leftContents.includes(page)
                    ? []
                    : [page];
            if (centerWidth > 1 && centerContents != []) {
                centerContents =
                    page < this.pageCount / 2
                        ? [
                              ...range(page, page - centerWidth / 2),
                              ...range(page + 1, page + (centerWidth / 2 + -1)),
                          ]
                        : [
                              ...range(page - 1, page - (centerWidth / 2 + -1)),
                              ...range(page, page + centerWidth / 2),
                          ];
            }
            return centerContents == []
                ? [...rightContents, 0, ...leftContents]
                : [...rightContents, 0, ...centerContents, 0, ...leftContents];
        },
    },
};
</script>
