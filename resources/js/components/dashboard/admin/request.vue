<template>
    <div>
        <div class="w-full flex justify-around space-x-5">
            <div class="w-3/5">
                <div class="flex justify-between items-center">
                    <p class="text-blue-900 font-semibold blur-none tracking-wide antialiased font-roboto text-base">
                        Request Management
                    </p>
                    <a-button @click="completedRequestModal" type="link">Completed Request</a-button>
                </div>
                <DisplayCompletedRequest v-if="completedRequest == true" class="w-full"
                @value-emitted="handleValueCompletedRequest" />
                <div class="border-2 border-gray-300 rounded p-2 w-full">
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
                                <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`"
                                    :value="selectedKeys[0]" style="width: 188px; margin-bottom: 8px; display: block"
                                    @change="(e) =>
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
                                        <a v-if="record.requestformstatus_id == 1"
                                            @click="startProcess(record.id)">Proccess</a>

                                        <a v-if="record.requestformstatus_id == 2"
                                            @click="startPickUp(record.id)">Release</a>
                                        <a v-if="record.requestformstatus_id == 3"
                                            @click="release(record.id)">Taken/Picked Up</a>
                                    </span>
                                </div>
                            </template>
                        </template>
                    </a-table>
                </div>
            </div>
        </div>
        <Modal v-model="loadingModal" width="360" :closable="false" :mask-closable="false">
            <template #header>
                Please Wait
            </template>
            <div style="text-align:center">
                <p>The organization will send an email to the requester. Please wait while the system processes and sends the email. Check the organization's email for confirmation</p>
            </div>
            <template #footer>
                <Button v-if="loadingModal_loading" type="success" size="large" long @click="loadingRequest()" :loading="loadingModal_loading">Loading</Button>
                <Button v-if="!loadingModal_loading" type="success" size="large" long @click="loadingRequest()" :loading="loadingModal_loading">Done</Button>
            </template>
        </Modal>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from "vue";
import { SearchOutlined, SyncOutlined, } from "@ant-design/icons-vue";
import DisplayCompletedRequest from "./request/displayCompletedRequest.vue";

export default defineComponent({
    name: 'AdminRequest',
    components: {
        SearchOutlined,
        SyncOutlined,
        DisplayCompletedRequest,
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
        const completedRequest  = ref(false);

        return {
            expandedRowKeys,
            data,
            columns,
            state,
            searchInput,
            handleSearch,
            handleReset,
            completedRequest
        };
    },
    data() {
        return {
            // Your component data goes here
            loadingModal: false,
            loadingModal_loading: true,

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
                thiss.data = response.data;
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        handleExpand(expanded, record) {
            this.expandedRowKeys = expanded ? [record.id] : [];
        },
        loadingRequest(){
            const thiss = this;
            thiss.loadingModal = false;
        },
        async startProcess(id) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            thiss.loadingModal = true;
            await axios.post(`/api/admin/startProcessRequestForm`, { id: id }, { headers })
                .then(function (response) {
                    console.log(response);
                    thiss.fetchData();
                    thiss.loadingModal_loading = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async startPickUp(id) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            thiss.loadingModal = true;
            await axios.post(`/api/admin/startPickUpRequestForm`, { id: id }, { headers })
                .then(function (response) {
                    console.log(response);
                    thiss.fetchData();
                    thiss.loadingModal_loading = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async release(id) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            await axios.post(`/api/admin/startReleasedRequestForm`, { id: id }, { headers })
                .then(function (response) {
                    console.log(response);
                    thiss.fetchData();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        completedRequestModal() {
            const thiss = this;
            thiss.completedRequest = true;
        },
        handleValueCompletedRequest(value) {
            const thiss = this;
            thiss.completedRequest = value;
        }
    },
    mounted() {
        const thiss = this;
        thiss.fetchData();
        // Code to run when the component is mounted
    }
});
</script>

<style scoped>
/* Your component styles go here */
</style>
