<template>
    <div class="w-full flex justify-center">
        <div class="w-2/3">
            <div class="flex justify-between items-center">
                <p class="text-blue-500 font-semibold blur-none tracking-wide antialiased font-roboto text-base ">
                    Enrolment Data SY 2023-2024</p>
                <a-modal v-model:open="open" title="Content" width="1200px" style="top: 20px" :maskClosable="false"
                    @ok="handleOk('formValidate')" @cancel="onExit">
                    <template #footer>
                        <a-button key="submit" class="bg-gray-200 mb-2"
                            @click="handleOk('formValidate')">Submit</a-button>
                    </template>
                    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top"
                        class="py-5 space-y-3">
                        <FormItem label="Enrollment Content" prop="editorData">
                            <ckeditor :editor="editor" v-model="formValidate.editorData" :config="editorConfig" placeholder="Write Content"></ckeditor>
                        </FormItem>
                    </Form>
                </a-modal>

                <a-button @click="open = true" type="link">Edit</a-button>
            </div>
            <div class=" border-2 shadow-lg p-3 drop-shadow-lg">
                <p v-html="this.data.content"
                    class="text-justify blur-none font-medium indent-4 leading-loose tracking-wide antialiased">
                </p>
            </div>
        </div>

    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { defineComponent, reactive, computed, ref } from 'vue';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default defineComponent({
    data() {
        return {
            data: '',
            open: ref(false),
            editor: ClassicEditor,
            formValidate: {
                editorData: '',
            },
            ruleValidate: {
                editorData: [
                    { required: true, message: 'The Content cannot be empty', trigger: 'blur' }
                ],
            },
            editorConfig: {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontColor', '|',
                    // 'alignment', 'bulletedList', 'numberedList', 'indent', 'outdent', '|',
                    'link', '|',
                    'undo', 'redo'
                ]
            }
        }
    },
    methods: {
        handleOk(name) {
            this.open = false;

            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/storeEnrollmentContent`, this.formValidate, { headers })
                        .then(function (response) {
                            console.log(response);
                            notification.success({
                                message: 'Notification',
                                description: 'Enrollment Content Updated',
                            });
                            thiss.formValidate.editorData = ''
                        })
                        .catch(function (error) {

                        });

                } else {

                }
            })
        },
        onExit() {
            this.formValidate.editorData = ''
        }
    },
    async mounted() {
        const thiss = this
        const headers = {
            Authorization: `Bearer ${localStorage.getItem('authToken')}`,
        };
        try {
            const response = await axios.get(`/api/admin/getEnrollmentContent`, { headers });
            thiss.data = response.data
        } catch (error) {
            console.error('Error fetching data:', error);
        }

    },
    created() {

    }
})
</script>
