<template>
    <div class="w-full flex items-center justify-center" :style="minHeightStyle">
        <div class="w-2/4 p-10">
            <Alert v-if="requestFormSuccess" type="success" show-icon>
                Success!
                <template #desc>Your request form is being processed by the administrator. A notification will be sent
                    to the email address you provided. Please check your inbox for updates.</template>
            </Alert>

            <div class="flex justify-between">
                <p class="font-semibold text-start text-2xl">
                    Request Form
                </p>

                <p @click="$router.push('/')"  class="cursor-pointer font-semibold text-start text-2xl">
                    DES – PRMS
                </p>
            </div>
            <div class="border-2 shadow-lg p-3 drop-shadow-lg">
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top"
                    class="py-5 space-y-5">
                    <FormItem label="Date" prop="date">
                        <DatePicker style="width:100%" type="date" placeholder="Select date"
                            v-model="formValidate.date">
                        </DatePicker>
                    </FormItem>
                    <FormItem label="Email Address" prop="emailAddress">
                        <Input v-model="formValidate.emailAddress" placeholder="Enter Email Address"></Input>
                    </FormItem>
                    <FormItem label="Name of Requester" prop="nameOfRequester">
                        <Input v-model="formValidate.nameOfRequester" placeholder="Enter Name of Requester"></Input>
                    </FormItem>
                    <FormItem label="Name of Learner" prop="nameOfLearner">
                        <Input v-model="formValidate.nameOfLearner" placeholder="Enter Name of Learner"></Input>
                    </FormItem>
                    <FormItem label="School Year Graduated" prop="schoolYearGraduated">
                        <Input v-model="formValidate.schoolYearGraduated"
                            placeholder="Enter School Year Graduated"></Input>
                    </FormItem>
                    <FormItem label="Purpose" prop="purpose">
                        <Input v-model="formValidate.purpose" placeholder="Enter Purpose"></Input>
                    </FormItem>
                    <FormItem label="Issued by" prop="issuedBy">
                        <Input v-model="formValidate.issuedBy" placeholder="Enter Issued by"></Input>
                    </FormItem>
                    <FormItem label="Document Category" prop="documentCategory">
                        <Input v-model="formValidate.documentCategory" placeholder="Enter Document Category"></Input>
                    </FormItem>
                </Form>
                <div class="flex justify-end">
                    <a-button key="submit" class="bg-gray-200 mb-2" @click="handleOk('formValidate')">Submit</a-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    data() {
        return {
            screenHeight: window.innerHeight - 100,
            formValidate: {
                date: '',
                emailAddress: '',
                nameOfRequester: '',
                nameOfLearner: '',
                schoolYearGraduated: '',
                purpose: '',
                issuedBy: '',
                documentCategory: '',
            },
            ruleValidate: {
                date: [
                    { required: true, type: 'date', message: 'The Date cannot be empty', trigger: 'blur' }
                ],
                emailAddress: [
                    { required: true, message: 'The Email Address cannot be empty', trigger: 'blur' }
                ],
                nameOfRequester: [
                    { required: true, message: 'The No. of Days cannot be empty', trigger: 'blur' }
                ],
                nameOfLearner: [
                    { required: true, message: 'The Name of Learner cannot be empty', trigger: 'blur' }
                ],
                schoolYearGraduated: [
                    { required: true, message: 'The School Year Graduated cannot be empty', trigger: 'blur' }
                ],
                purpose: [
                    { required: true, message: 'The Purpose cannot be empty', trigger: 'blur' }
                ],
                issuedBy: [
                    { required: true, message: 'The Issued By cannot be empty', trigger: 'blur' }
                ],
                documentCategory: [
                    { required: true, message: 'The Document Category cannot be empty', trigger: 'blur' }
                ],
            },
            requestFormSuccess: false,
        }
    },
    methods: {
        async handleOk(name) {
            const thiss = this

            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/storeRequestForm`, this.formValidate)
                        .then(function (response) {
                            console.log(response);
                            thiss.requestFormSuccess = true;
                            setTimeout(() => {
                                thiss.requestFormSuccess = false;
                                thiss.$refs.formValidate.resetFields();
                            }, 10000);
                        })
                        .catch(function (error) {

                        });
                } else {

                }
            })

        },

    },
    computed: {
        minHeightStyle() {
            return {
                minHeight: `${this.screenHeight}px`
            }
        },
    }
});
</script>

<style scoped></style>
