<template>
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-head-row justify-content-between">
                <h4 class="card-title"><strong>{{ title }}</strong></h4>
                <div class="d-flex align-items-center">
                    <div class="form-group">
                        <div class="input-icon">
                            <input
                                type="text"
                                v-model="keyword"
                                class="form-control"
                                placeholder="Search for..."
                            />
                            <span class="input-icon-addon">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                    <div>
                        <a
                            v-if="canAdd"
                            :href="`${url}/create`"
                            type="button"
                            class="btn btn-primary btn-round ml-auto"
                        >
                            <div class="fa fa-fw fa-plus mr-2"></div>
                            Add Data
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 table-hover">
                    <thead class="bg-grey1">
                        <tr>
                            <th class="text-center">No.</th>
                            <th
                                v-for="(header, index) in headers"
                                :key="index"
                                :class="`text-${
                                    header['align'] ? header['align'] : 'center'
                                }`"
                            >
                                {{ header["text"] }}
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="isContentLoading">
                            <td :colspan="headers.length + 2">
                                <div class="d-flex justify-content-center">
                                    <div class="loader loader-lg"></div>
                                </div>
                            </td>
                        </tr>
                        <template v-if="!isContentLoading">
                            <tr
                                v-for="(content, index) in contents"
                                :key="index"
                            >
                                <td class="text-center">{{ index+1 }}</td>
                                <td
                                    v-for="(header, _index) in headers"
                                    :key="_index"
                                    :class="`text-${
                                        header['align']
                                            ? header['align']
                                            : 'center'
                                    }`"
                                >
                                    <slot
                                        :name="`${header['value']}`"
                                        :content="content"
                                        :value="content[header['value']]"
                                    >
                                        <span
                                            :class="`text-${
                                                header['align']
                                                    ? header['align']
                                                    : 'left'
                                            }`"
                                            >{{
                                                resolve(
                                                    content,
                                                    header["value"]
                                                )
                                            }}</span
                                        >
                                    </slot>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <slot
                                            name="left-action"
                                            :content="content"
                                        >
                                        </slot>
                                        <a
                                            v-if="canEdit"
                                            :href="`${url}/${content.id}/edit`"
                                            type="button"
                                            class="btn btn-xs bg-primary mr-1 text-white"
                                        >
                                            Edit
                                        </a>
                                        <button
                                            v-if="canDelete"
                                            @click="deleteData(content.id)"
                                            type="button"
                                            class="btn btn-xs btn-danger"
                                        >
                                            Delete
                                        </button>
                                        <slot
                                            name="right-action"
                                            :content="content"
                                        >
                                        </slot>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="px-5 mt-4">
                <paginate-content
                    @onPageClick="handlePageItemClick"
                    :page="page"
                    :per_page="per_page"
                    :total="total"
                />
            </div>
        </div>
    </div>
</template>
<script>
import PaginateContent from "./PaginateContent.vue";
let fetchController = new AbortController();
export default {
    components: { PaginateContent },
    props: {
        url: {
            type: String,
            required: true,
        },
        headers: {
            type: Array,
            required: true,
        },
        title: {
            type: String,
            reqired: true,
        },
        canAdd: {
            type: Boolean,
            default: true,
        },
        canEdit: {
            type: Boolean,
            default: true,
        },
        canDelete: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            isContentLoading: false,
            contents: [],
            keyword: "",
            total: 0,
            page: 1,
            per_page: 15,
            isSearchFocused: false,
        };
    },
    watch: {
        page(newPage, oldPage) {
            this.fetchData();
        },
        keyword() {
            this.fetchData();
        },
    },
    created() {
        this.fetchData();
    },
    methods: {
        resolve(obj, path, separator = ".") {
            var properties = path.split(separator);
            return properties.reduce((prev, curr) => prev && prev[curr], obj);
        },
        handlePageItemClick(page) {
            this.page = page;
        },
        async fetchData() {
            try {
                fetchController.abort();
            } catch (err) {}
            this.isContentLoading = true;
            const { page, per_page, keyword } = this;
            fetchController = new AbortController();
            const response = await httpClient.get(`${this.url}/datatable`, {
                signal: fetchController.signal,
                params: { page, per_page, keyword },
            });
            const result = response.data.result;
            this.contents = result.data;
            this.total = result.total;
            this.isContentLoading = false;
        },
        async deleteData(id) {
            Swal.fire({
                title: "Apakah anda yakin ingin menghapus data ini?",
                showDenyButton: true,
                confirmButtonText: `Yakin`,
                denyButtonText: `Tidak`,
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await httpClient.delete(`${this.url}/${id}`);
                    Swal.fire("Data berhasil dihapus!", "", "success");
                    this.fetchData();
                } else if (result.isDenied) {
                    Swal.fire("Proses hapus dibatalkan", "", "info");
                    this.fetchData();
                }
            });
        },
    },
};
</script>
