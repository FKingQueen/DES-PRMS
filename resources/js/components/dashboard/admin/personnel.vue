<template>
    <div class="w-full flex justify-center">
        <div class="w-1/2">
            <div class="flex justify-between items-center">
                <p class="text-blue-500 font-semibold blur-none tracking-wide antialiased font-roboto text-base ">
                    Personnel Management</p>
            </div>
            <div class="border border-gray-500 p-2 w-full">
                <a-button @click="addPersonnelModal" class="bg-gray-200 mb-2">Add Personnel</a-button>
                <NewPersonnel v-if="addPersonnel == true" class="w-full" @value-emitted="handleValueAddPersonnnel" />
                <a-table :columns="columns" :data-source="data" :expanded-row-keys="expandedRowKeys"
                    :row-key="record => record.id" @expand="handleExpand">
                    <template #expandedRowRender="{ record }">
                        <p style="margin: 0" class="w-full">
                            <DisplayPersonnel class="w-full" :id="record.id" />
                        </p>
                    </template>
                    <template #expandColumnTitle>
                        <span style="color: red">More</span>
                    </template>
                    <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                        <div style="padding: 8px">
                            <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`"
                                :value="selectedKeys[0]" style="width: 188px; margin-bottom: 8px; display: block"
                                @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                                @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)" />
                            <a-button type="primary" size="small" style="width: 90px; margin-right: 8px"
                                @click="handleSearch(selectedKeys, confirm, column.dataIndex)">
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
                        <span v-if="state.searchText && state.searchedColumn === column.dataIndex">
                            <template v-for="(fragment, i) in text
                                .toString()
                                .split(new RegExp(`(?<=${state.searchText})|(?=${state.searchText})`, 'i'))">
                                <mark v-if="fragment.toLowerCase() === state.searchText.toLowerCase()" :key="i"
                                    class="highlight">
                                    {{ fragment }}
                                </mark>
                                <template v-else>{{ fragment }}</template>
                            </template>
                        </span>
                        <template v-if="column.key === 'role_id'">
                            <span class="space-x-3">
                                <p v-if="record.role_id == 1"> Admin</p>
                                <p v-else>Personnel</p>
                            </span>
                        </template>
                        <template v-if="column.key === 'action'">
                            <span class="space-x-3">
                                <a @click="editPersonnelModal(record.id)">Edit</a>
                                <a-divider type="vertical" />
                                <Poptip confirm title="Are you sure you want to delete this item?" @on-ok="remove(index)">
                                    <a class="hover:text-red-500">Delete</a>
                                </Poptip>
                            </span>

                        </template>
                    </template>
                </a-table>
            </div>
            <EditPersonnel v-if="editPersonnel == true" class="w-full" :id="editID"
                @value-emitted="handleValueEditPersonnel" />
        </div>
    </div>
</template>

<script>
import NewPersonnel from './personnel/addPersonnel.vue';
import EditPersonnel from './personnel/editPersonnel.vue';
import DisplayPersonnel from './personnel/displayPersonnel.vue';
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
export default defineComponent({
    components: {
        SearchOutlined,
        NewPersonnel,
        EditPersonnel,
        DisplayPersonnel
    },
    setup() {
        const data = ref([]); // Make `data` reactive
        const expandedRowKeys = ref([]); // Track expanded rows

        const columns = [
            {
                title: 'ID',
                dataIndex: 'id',
                key: 'id',
                width: 80,
            },
            {
                title: 'Role',
                dataIndex: 'role_id',
                key: 'role_id',
                fixed: true,
            },
            {
                title: 'Name',
                dataIndex: 'name',
                key: 'name',
                customFilterDropdown: true,
                onFilter: (value, record) => record.name.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            },
            {
                title: 'Action',
                key: 'action',
                width: 200,
            },
        ];

        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();

        const handleSearch = (selectedKeys, confirm, dataIndex) => {
            confirm();
            state.searchText = selectedKeys[0];
            state.searchedColumn = dataIndex;
        };
        const handleReset = clearFilters => {
            clearFilters({
                confirm: true,
            });
            state.searchText = '';
        };
        // modal
        const addPersonnel = ref(false);
        const editPersonnel = ref(false);

        return {
            // datatable
            data,
            columns,
            state,
            searchInput,
            handleSearch,
            handleReset,
            // modal
            addPersonnel,
            editPersonnel,
            editID: ref(''),
            expandedRowKeys, // Expose expanded row keys
        };
    },
    mounted() {
        const thiss = this
        thiss.fetchData();
    },
    methods: {
        remove(key) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deletePersonnel`, { id: this.data[key].id }, { headers })
                .then(function (response) {
                    thiss.data.splice(key, 1);
                    notification.success({
                        message: 'Notification',
                        description: 'The Personnel is Successfully Deleted',
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        handleValueAddPersonnnel(value) {
            const thiss = this
            thiss.addPersonnel = value
        },
        handleValueEditPersonnel(value) {
            const thiss = this
            thiss.editPersonnel = value
            thiss.fetchData();
        },
        addPersonnelModal() {
            const thiss = this
            thiss.addPersonnel = true
        },
        editPersonnelModal(id) {
            const thiss = this
            thiss.editID = id
            thiss.editPersonnel = true
        },
        async fetchData() {
            const thiss = this
            const headers = {
                Authorization: `Bearer ${localStorage.getItem('authToken')}`,
            };
            try {
                const response = await axios.get('/api/admin/getPersonnel', { headers });
                // Map the data to the expected format for DataTables
                console.log(response.data);
                thiss.data = response.data
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        handleExpand(expanded, record) {
            this.expandedRowKeys = expanded ? [record.id] : [];
        },

    }
});
</script>
