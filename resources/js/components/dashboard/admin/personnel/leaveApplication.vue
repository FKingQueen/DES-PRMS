<template>
    <div>
        <a-table :columns="columns" :data-source="data" :expanded-row-keys="expandedRowKeys"
            :row-key="(record) => record.id" @expand="handleExpand">
            <template #expandedRowRender="{ record }">
                <!-- <p style="margin: 0" class="w-full">
                    {{ record.user.name }}
                </p> -->
                <div class="border bg-white drop-shadow p-2 space-y-2">
                    <p>Name: {{ record.name }}</p>
                    <p>Position: {{ record.position }}</p>
                    <p>Leave Type: {{ record.leaveCategory }}</p>
                    <p>Date Filed: {{ record.dateFiled }}</p>
                    <p>
                        No. of Days:
                        <span class="text-rose-700">{{ record.noOfDays }}</span>
                    </p>
                    <p>Date of Leave: {{ record.dateOfLeave }} to {{ record.dateOfLeaveEnd }}</p>
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
                <template v-if="column.key === 'action'">
                    <div class="flex items-center justify-center w-full">
                        <span class="space-x-3">
                            <a @click="acceptLA(record.id, 1)">Accept</a>
                            <a-divider type="vertical" />
                            <a @click="acceptLA(record.id, 2)" class="hover:text-red-500">Reject</a>
                        </span>
                    </div>
                </template>
            </template>
        </a-table>
        <!-- Add your template content here -->
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from "vue";
import { SearchOutlined } from "@ant-design/icons-vue";

export default defineComponent({
    name: "LeaveApplication",
    components: {
        SearchOutlined,
    },
    setup() {
        const data = ref([]); // Make `data` reactive
        const expandedRowKeys = ref([]); // Track expanded rows
        const columns = [
            {
                title: "Leave Type",
                dataIndex: "leaveCategory",
                key: "leaveCategory",
                width: 180,
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
                width: 175,
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
            // Define your reactive data properties here
        };
    },
    mounted() {
        const thiss = this;
        thiss.fetchData();
    },
    methods: {
        async fetchData() {
            const thiss = this;
            this.data = [];
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            try {
                const response = await axios.get(
                    "/api/admin/getLeaveApplications",
                    { headers }
                );
                // Map the data to the expected format for DataTables
                response.data.forEach((item, index) => {
                    let result = new Date(item.dateOfLeave);
                    result.setDate(result.getDate() + item.noOfDays);
                    const year = result.getFullYear();
                    const month = String(result.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                    const day = String(result.getDate()).padStart(2, '0');

                    thiss.data.push({
                        id: item.id,
                        position: item.user.position,
                        name: item.user.name,
                        leaveCategory: item.leaveCategory,
                        dateFiled: item.dateFiled,
                        noOfDays: item.noOfDays,
                        dateOfLeave: item.dateOfLeave,
                        dateOfLeaveEnd: `${year}-${month}-${day}`,
                    });
                });
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        // calculateDateOfLeaveEnd(item) {
        //     const dateOfLeave = new Date(item.dateOfLeave);
        //     const dateOfLeaveEnd = addDays(dateOfLeave, item.noOfDays);
        //     return format(dateOfLeaveEnd, 'yyyy-MM-dd');
        // },
        handleExpand(expanded, record) {
            this.expandedRowKeys = expanded ? [record.id] : [];
        },
        async acceptLA(id, value) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            await axios.post(`/api/admin/acceptLeaveApplication`, { id: id, value: value }, { headers })
                .then(function (response) {
                    console.log(response);
                    thiss.fetchData();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
});
</script>

<style scoped>
/* Add your component styles here */
</style>
