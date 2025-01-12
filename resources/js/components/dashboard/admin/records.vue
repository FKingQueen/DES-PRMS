<template>
    <div class="w-full flex justify-around space-x-5">
        <div class="w-3/5">
            <div class="flex justify-between items-center">
                <p class="text-blue-900 font-semibold blur-none tracking-wide antialiased font-roboto text-base">
                    201 Files Management
                </p>
                <a-button @click="addDocumentModal" class="bg-gray-200 mb-2">Add 201 File</a-button>
            </div>
            <NewDocument v-if="addDocument == true" class="w-full" @value-emitted="handleValueAddPersonnnel" />
            <div class="border-2 border-gray-300 rounded p-2 w-full">
                <a-table :columns="columns" :data-source="data" :expanded-row-keys="expandedRowKeys"
                    :row-key="(record) => record.id" @expand="handleExpand">
                    <template #expandedRowRender="{ record }">
                        <!-- <div v-for="doc in record.document"> -->
                        <div>
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                            Document Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="doc in record.document">
                                        <td
                                            class="px-6 py-2 whitespace-nowrap border-b border-gray-300 cursor-pointer hover:underline">
                                            <a @click="downloadDocument(doc.id)">{{ doc.fileName.replace("-" +
                                                record.name, "") }}</a>

                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap border-b border-gray-300">
                                            <a @click="downloadDocument(doc.id)">Download</a>
                                            <a-divider type="vertical" />
                                            <Poptip confirm title="Are you sure you want to delete this document?"
                                                @on-ok="deleteDocument(index, doc.id)">
                                                <a class="hover:text-red-500">Delete</a>
                                            </Poptip>
                                        </td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <template #expandColumnTitle>
                        <span style="color: red">More</span>
                    </template>
                    <template #customFilterDropdown="{
                        setSelectedKeys,
                        selectedKeys,
                        confirm,
                        clearFilters,
                        column,
                    }">
                        <div style="padding: 8px">
                            <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`"
                                :value="selectedKeys[0]" style="
                                    width: 188px;
                                    margin-bottom: 8px;
                                    display: block;
                                " @change="(e) =>
                                    setSelectedKeys(
                                        e.target.value
                                            ? [e.target.value]
                                            : []
                                    )
                                    " @pressEnter="
                                        handleSearch(
                                            selectedKeys,
                                            confirm,
                                            column.dataIndex
                                        )
                                        " />
                            <a-button type="primary" size="small" style="width: 90px; margin-right: 8px" @click="
                                handleSearch(
                                    selectedKeys,
                                    confirm,
                                    column.dataIndex
                                )
                                ">
                                <template #icon>
                                    <SearchOutlined />
                                </template>
                                Search
                            </a-button>
                            <a-button size="small" style="width: 90px" @click="handleReset(clearFilters)">
                                Reset
                            </a-button>
                        </div>
                    </template>
                    <template #customFilterIcon="{ filtered }">
                        <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
                    </template>
                    <template #bodyCell="{ text, column, record, index }">
                        <span v-if="
                            state.searchText &&
                            state.searchedColumn === column.dataIndex
                        ">
                            <template v-for="(fragment, i) in text
                                .toString()
                                .split(
                                    new RegExp(
                                        `(?<=${state.searchText})|(?=${state.searchText})`,
                                        'i'
                                    )
                                )">
                                <mark v-if="
                                    fragment.toLowerCase() ===
                                    state.searchText.toLowerCase()
                                " :key="i" class="highlight">
                                    {{ fragment }}
                                </mark>
                                <template v-else>{{ fragment }}</template>
                            </template>
                        </span>
                        <template v-if="column.key === 'role_id'">
                            <span class="space-x-3">
                                <p v-if="record.role_id == 1">Admin</p>
                                <p v-else>Personnel</p>
                            </span>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import NewDocument from "./records/addDocument.vue";

export default defineComponent({
    name: 'Records',
    components: {
        NewDocument,
        SearchOutlined
    },
    setup() {
        const addDocument = ref(false);
        return {
            addDocument
        }
    },
    setup() {
        const data = ref([]); // Make `data` reactive
        const expandedRowKeys = ref([]); // Track expanded rows

        const columns = [
            {
                title: "Role",
                dataIndex: "role_id",
                key: "role_id",
                fixed: true,
            },
            {
                title: "Name",
                dataIndex: "name",
                key: "name",
                customFilterDropdown: true,
                onFilter: (value, record) =>
                    record.name
                        .toString()
                        .toLowerCase()
                        .includes(value.toLowerCase()),
                onFilterDropdownOpenChange: (visible) => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            },
        ];

        const state = reactive({
            searchText: "",
            searchedColumn: "",
        });
        const searchInput = ref();

        const handleSearch = (selectedKeys, confirm, dataIndex) => {
            confirm();
            state.searchText = selectedKeys[0];
            state.searchedColumn = dataIndex;
        };
        const handleReset = (clearFilters) => {
            clearFilters({
                confirm: true,
            });
            state.searchText = "";
        };
        // modal
        const addDocument = ref(false);

        return {
            // datatable
            data,
            columns,
            state,
            searchInput,
            handleSearch,
            handleReset,

            addDocument,
            // modal
            editID: ref(""),
            expandedRowKeys, // Expose expanded row keys

        };
    },
    data() {
        return {
            // Your component data goes here
            data: reactive([]),
        };
    },
    methods: {
        addDocumentModal() {
            const thiss = this;
            thiss.addDocument = true;
        },
        handleValueAddPersonnnel(value) {
            this.addDocument = value;
            this.fetchData();
        },
        async fetchData() {
            const thiss = this;
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            try {
                const response = await axios.get("/api/admin/getDocuments", {
                    headers,
                });
                // Map the data to the expected format for DataTables
                thiss.data = response.data;

            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        handleExpand(expanded, record) {
            this.expandedRowKeys = expanded ? [record.id] : [];
        },
        downloadDocument(id) {
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            window.location.href = `/api/admin/downloadDocument/${id}?Authorization=${headers.Authorization}`;
        },
        deleteDocument(index, id) {
            const thiss = this;
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            axios
                .post(
                    `/api/admin/deleteRecordDocument`,
                    { id: id },
                    { headers }
                )
                .then(function (response) {
                    console.log(response);
                    // notification.success({
                    //     message: "Notification",
                    //     description: "The D is Successfully Deleted",
                    // });
                    thiss.fetchData();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    async mounted() {
        const thiss = this
        thiss.fetchData();
    },
    created() {
        const thiss = this
        this.token = localStorage.getItem('authToken')

    }
});
</script>

<style scoped>
/* Your component styles go here */
</style>
