<template>
    <div class="w-full flex justify-center">
        <a-modal v-model:open="open" title="New 201 File" width="1000px" style="top: 20px" :maskClosable="false"
            @ok="handleOk('formValidate')" @cancel="onExit">
            <template #footer>
                <a-button key="submit" class="bg-gray-200 mb-2" :loading="loading"
                    @click="handleOk('formValidate')">Done</a-button>
            </template>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="">
                <FormItem label="Personnel" prop="personnel" class="p-0  mt-5">
                    <Select v-model="formValidate.personnel" filterable :remote-method="selectPersonnel"
                        :loading="loadingDocument" placeholder="Search | Select Personnel">
                        <Option v-for="(option, index) in personnelOption" :value="option.value" :key="index">{{
                            option.label
                        }}
                        </Option>
                    </Select>
                </FormItem>

                <div class="w-full flex justify-center items-center">
                    <span v-if="formValidate.personnel == ''" class="text-red-500">Select Personnel to Upload
                        files</span>
                </div>

                <FormItem label="Document" prop="document">
                    <Upload :disabled="formValidate.personnel == ''" type="drag" ref="uploads" :headers="uploadHeaders"
                        :data="{ id: formValidate.personnel }" :on-remove="handleRemove" :on-success="handleSuccess"
                        :on-error="handleError" :on-format-error="handleFormatError"
                        action="/api/admin/uploadRecordDocument" multiple>
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                </FormItem>

            </Form>
        </a-modal>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import { data } from 'autoprefixer';

export default defineComponent({
    name: 'AddDocument',
    data() {
        return {
            loading: ref(false),
            open: ref(true),
            loadingDocument: false,

            token: '', // Replace with your actual token retrieval logic
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            visiblePreview: false,

            formValidate: reactive({
                document: '',
                personnel: '',
                document_file_id: '',
                fileName: ''

            }),
            ruleValidate: {
                document: [
                    { required: true, message: 'The Document cannot be empty', trigger: 'blur' }
                ],
                personnel: [
                    { required: true, message: 'The Personnel cannot be empty', trigger: 'blur' }
                ]
            },

            data: [],
            personnelOption: []
        };
    },
    computed: {
        uploadHeaders() {
            this.token = localStorage.getItem('authToken')
            return {
                'Authorization': `Bearer ${this.token}`,
                'X-CSRF-TOKEN': this.csrfToken
            };
        }
    },
    methods: {
        async handleOk(name) {
            const thiss = this
            thiss.open = false
            thiss.$emit("value-emitted", false); // Emit the value
        },
        onExit() {
            const thiss = this
            thiss.$emit("value-emitted", false); // Emit the value
        },
        handleRemove(file, fileList){
            console.log('id: ',file.response.id);

            const thiss = this;
            const headers = {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            axios
                .post(
                    `/api/admin/deleteRecordDocument`,
                    { id: file.response.id },
                    { headers }
                )
                .then(function (response) {
                    console.log(response);
                    // notification.success({
                    //     message: "Notification",
                    //     description: "The D is Successfully Deleted",
                    // });
                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        handleSuccess(res, file) {
            const thiss = this
        },
        handleError(res, file) {
        },
        handleFormatError(file) {
            notification.warning({
                message: 'The file format is incorrect',
                description: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleView() {
            this.visiblePreview = true;
        },
        selectPersonnel(query) {
            const thiss = this;
            if (query !== '') {
                this.loadingDocument = true;
                setTimeout(() => {
                    this.loadingDocument = false;
                    const list = thiss.data.map(item => {
                        return {
                            value: item.value,
                            label: item.label
                        };
                    });
                    thiss.personnelOption = list.filter(item => item.label.toLowerCase().indexOf(query.toLowerCase()) > -1);
                }, 200);
            } else {
                thiss.personnelOption = thiss.data;
            }
        },
        async fetchData() {
            const thiss = this;
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            try {
                const response = await axios.get("/api/admin/getPersonnel", {
                    headers,
                });
                // Map the data to the expected format for DataTables
                thiss.data = response.data.map(item => ({
                    value: String(item.id),
                    label: item.name,
                }));

                thiss.personnelOption = thiss.data;
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },

    },
    mounted() {
        // Your mounted lifecycle hook goes here
        const thiss = this;
        thiss.fetchData();
    },
    created() {
        this.token = localStorage.getItem('authToken')
    }
});
</script>

<style scoped>
/* Your component styles go here */
</style>
