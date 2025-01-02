<template>
    <div class="w-full flex justify-center">
        <a-modal v-model:open="open" title="New Personnel" width="1000px" :maskClosable="false" @ok="handleOk('formValidate')"
            @cancel="onExit">
            <template #footer>
                <a-button key="submit" class="bg-gray-200 mb-2" :loading="loading" @click="handleOk('formValidate')">Submit</a-button>
            </template>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="">
                <FormItem label="Image" prop="image">
                    <Upload type="drag" ref="uploads" :headers="{ 'Authorization': `Bearer ${token}` }"
                        :on-success="handleSuccess" :on-error="handleError" :format="['jpg', 'jpeg', 'png']"
                        :on-format-error="handleFormatError" action="/api/admin/uploadPersonnelImage">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <!-- src="/img/slides/Slide3Mobile.png" -->
                    <ImagePreview v-model="visiblePreview" :preview-list="[`/img/uploadPersonnelImage/${formValidate.image}`]" />
                    <div v-if="formValidate.image" class="demo-upload-list">
                        <Image :src="`/img/uploadPersonnelImage/${formValidate.image}`" fit="cover" width="100%" height="100%" />
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-eye-outline" @click="handleView()"></Icon>
                            <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                        </div>
                    </div>
                </FormItem>
            </Form>
        </a-modal>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
export default defineComponent({
    components: {
        SearchOutlined,
    },
    data() {
        return {
            loading: ref(false),
            open: ref(true),

            token: '',
            visiblePreview: false,
            formValidate: {
                image: '',
            },
            ruleValidate: {
                image: [
                    { required: true, message: 'The image cannot be empty', trigger: 'blur' }
                ],
            },
        }
    },
    methods: {
        async handleOk(name) {
            const thiss = this

            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/storePersonnel`,{ headers })
                        .then(function (response) {
                            console.log(response.data);
                            thiss.open = false
                            this.$emit("value-emitted", false); // Emit the value
                        })
                        .catch(function (error) {

                        });

                } else {

                }
            })

        },
        onExit() {
            this.$emit("value-emitted", false); // Emit the value
        },
        handleSuccess(res, file) {
            this.formValidate.image = res
            console.log('res: ',res);
            console.log('file: ',file);
        },
        handleError(res, file) {
            console.log('res', res);
        },
        handleFormatError(file) {
            notification.warning({
                message: 'The file format is incorrect',
                description: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
    },
    created() {
        console.log(localStorage.getItem('authToken'));
        this.token = localStorage.getItem('authToken')
    }
});
</script>
