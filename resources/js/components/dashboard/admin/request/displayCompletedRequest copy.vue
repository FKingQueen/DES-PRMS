<template>
    <div>
        <a-modal v-model:open="open" title="All Leave Application" width="1000px" style="top: 20px"
            :maskClosable="false" @ok="handleOk()" @cancel="onExit">
            <template #footer>
                <a-button key="submit" class="bg-gray-200 mb-2" @click="handleOk()">Close</a-button>
            </template>
            <a-table :columns="columns" :data-source="data" :expanded-row-keys="expandedRowKeys"
                :row-key="(record) => record.id" @expand="handleExpand">
                <template #expandedRowRender="{ record }">
                    <div class="border bg-white drop-shadow p-2 space-y-2">
                        <p>Request Name: {{ record.nameOfRequester }}</p>
                        <p>Learner Name: {{ record.nameOfLearner }}</p>
                        <p>School Year Graduated: {{ record.schoolYearGraduated }}</p>
                        <p>Purpose: {{ record.purpose }}</p>
                        <p>
                            Issued By: {{ record.issuedBy }}
                        </p>
                        <p>Document Category: {{ record.documentCategory }}</p>
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
                        <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`" :value="selectedKeys[0]"
                            style="width: 188px; margin-bottom: 8px; display: block" @change="(e) =>
                                setSelectedKeys(
                                    e.target.value ? [e.target.value] : []
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
                    <template v-if="column.key === 'status'">
                        <div class="flex items-center justify-center w-full">
                            <a-tag v-if="record.requestformstatus_id == 1" color="error">Received</a-tag>
                            <a-tag v-if="record.requestformstatus_id == 2" color="processing">
                                <template #icon>
                                    <sync-outlined :spin="true" />
                                </template>
                                processing
                            </a-tag>
                            <a-tag v-if="record.requestformstatus_id == 3" color="success">Ready for
                                Release</a-tag>
                        </div>

                    </template>
                    <template v-if="column.key === 'action'">
                        <div class="flex items-center w-full">
                            <span class="space-x-3">
                                <a v-if="record.requestformstatus_id == 1" @click="startProcess(record.id)">Proccess</a>

                                <a v-if="record.requestformstatus_id == 2" @click="startPickUp(record.id)">Release</a>
                                <a v-if="record.requestformstatus_id == 3" @click="release(record.id)">Taken/Picked
                                    Up</a>
                            </span>
                        </div>
                    </template>
                </template>
            </a-table>
        </a-modal>
        <!-- Add your template content here -->
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from "vue";
import { SearchOutlined } from "@ant-design/icons-vue";

export default defineComponent({
    name: 'DisplayCompletedRequest',
    components: {
        SearchOutlined,
    },
    setup() {
        const data = ref([]); // Make `data` reactive
        const expandedRowKeys = ref([]); // Track expanded rows
        const columns = [
            {
                title: "Requester Name",
                dataIndex: "nameOfRequester",
                key: "nameOfRequester",
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
                width: 175,
            },
            {
                title: "Learner Name",
                dataIndex: "nameOfLearner",
                key: "nameOfLearner",
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
                width: 175,
            },
            {
                title: "Status",
                dataIndex: "status",
                key: "status",
                width: 100,
            },
            {
                title: "Action",
                key: "action",
                width: 170,
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

        return {
            expandedRowKeys,
            data,
            columns,
            state,
            searchInput,
            handleSearch,
            handleReset,
        };
    },
    data() {
        return {
            // Your component data goes here
        };
    },
    methods: {
        async fetchData() {
            const thiss = this;
            this.data = [];
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            try {
                const response = await axios.get("/api/admin/getAllRequest", { headers });
                console.log(response);
                thiss.data = response.data;
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        handleExpand(expanded, record) {
            this.expandedRowKeys = expanded ? [record.id] : [];
        },
        handleOk() {
            const thiss = this
            thiss.$emit("value-emitted", false); // Emit the value
        },
        onExit() {
            const thiss = this
            thiss.$emit("value-emitted", false); // Emit the value
        },
    },
    mounted() {
        this.fetchData();
        // Your mounted lifecycle hook goes here
    }
});
</script>

<style scoped>
/* Your component styles go here */
</style>
</div>
