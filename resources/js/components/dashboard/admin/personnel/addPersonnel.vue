<template>
    <div class="w-full flex justify-center">
        <a-modal v-model:open="open" title="New Personnel" width="1000px" :maskClosable="false" @ok="handleOk">
            <template #footer>
                <a-button key="submit" class="bg-gray-200 mb-2" :loading="loading" @click="handleOk">Submit</a-button>
            </template>
            <!-- <div class="border p-5">
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top"
                    class="">
                    <Upload type="drag" ref="uploads" :headers="{ 'Authorization': `Bearer ${token}` }"
                        :on-success="handleSuccess" :on-error="handleError" :format="['jpg', 'jpeg', 'png']"
                        :on-format-error="handleFormatError" action="/api/admin/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                </Form>
            </div> -->
        </a-modal>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
export default defineComponent({
    components: {
        SearchOutlined,
    },
    setup() {
        // modal
        const loading = ref(false);
        const open = ref(true);
        const addPersonnelModal = () => {
            open.value = true;
        };
        const handleOk = () => {
            open.value = false;
        };

        return {
            // modal
            loading,
            open,
            addPersonnelModal,
            handleOk,
        };
    },
});
</script>
