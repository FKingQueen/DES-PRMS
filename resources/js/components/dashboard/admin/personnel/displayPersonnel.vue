<template>
    <div class="w-full flex justify-center border bg-white drop-shadow p-2">
        <div class="w-full">
            <div class="flex justify-between">
                <div>
                    <!-- {{ data.image }} -->
                    <img class="object-cover w-40" :src="`/img/personnel/${data.image}`">
                    <div class="text-center font-semibold">
                        <p class="">
                            {{ data.name }}
                        </p>
                        <p class="border border-gray-500 bg-yellow-200">
                            {{ data.position }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-2 w-full space-y-2 text-sm  text-gray-600 font-roboto ">
                        <p>
                            Item Number: {{ data.itemNumber }}
                        </p>
                        <p>
                            Employee Number: {{ data.employeeNumber }}
                        </p>
                        <p>
                            Date of Permanency: {{ data.datePermanency }}
                        </p>
                        <p>
                            Date of Original Appointment: {{ data.dateOrigAppointment }}
                        </p>
                        <p>
                            Date of Last Promotion/Appointment: {{ data.dateLastProAppointment }}
                        </p>
                    </div>
                </div>

                <div>
                    <div class="w-full">
                        <a-button class="bg-gray-200 mb-2 w-full" size="small" @click="openLA = true">Leave
                            Credits</a-button>
                        <a-modal v-model:open="openLA" title="Application for Leave" width="500px" style="top: 100px"
                            :maskClosable="false" @ok="handleOkLA('formValidateLA')">
                            <template #footer>
                                <a-button key="submit" class="bg-gray-200 mb-2" @click="handleOkLA('formValidateLA')"
                                    :loading="loading">Submit</a-button>
                            </template>
                            <Form ref="formValidateLA" :model="formValidateLA" :rules="ruleValidateLA"
                                label-position="top" class="py-5 space-y-5">
                                <FormItem label="Leave Category" prop="leaveCategory" class="p-0">
                                    <Select v-model="formValidateLA.leaveCategory" style="width:100%"
                                        placeholder="Leave Category">
                                        <Option v-for="item in leaveCategoryOptions" :value="item.value"
                                            :key="item.value">
                                            {{
                                                item.label }}</Option>
                                    </Select>
                                </FormItem>
                                <FormItem label="No. of Days" prop="noOfDays">
                                    <Input v-model="formValidateLA.noOfDays" placeholder="Enter No. of Days"></Input>
                                </FormItem>
                                <FormItem label="Date Filed" prop="dateFiled">
                                    <DatePicker style="width:100%" type="date" placeholder="Select date"
                                        v-model="formValidateLA.dateFiled">
                                    </DatePicker>
                                </FormItem>
                                <FormItem label="Date of Leave" prop="dateOfLeave">
                                    <DatePicker style="width:100%" type="date" placeholder="Select date"
                                        v-model="formValidateLA.dateOfLeave">
                                    </DatePicker>
                                </FormItem>

                            </Form>
                        </a-modal>
                    </div>
                    <div class="w-full">
                        <a-button class="bg-gray-200 mb-2 w-full" size="small" @click="openCP = true">Change
                            Password</a-button>
                        <a-modal v-model:open="openCP" title="Change Password" width="500px" style="top: 100px"
                            :maskClosable="false" @ok="handleOkCP('formValidateCP')">
                            <template #footer>
                                <a-button key="submit" class="bg-gray-200 mb-2" @click="handleOkCP('formValidateCP')"
                                    :loading="loading">Change Password</a-button>
                            </template>
                            <Form ref="formValidateCP" :model="formValidateCP" :rules="ruleValidateCP"
                                label-position="top" class="py-5 space-y-5">
                                <FormItem label="New Password" prop="passwd">
                                    <Input type="password" v-model="formValidateCP.passwd" placeholder="New Password"></Input>
                                </FormItem>
                                <FormItem label="Confirm Password" prop="passwdCheck">
                                    <Input type="password" v-model="formValidateCP.passwdCheck" placeholder="New Password"></Input>
                                </FormItem>
                            </Form>
                        </a-modal>
                    </div>

                </div>
            </div>
            <div class="flex items-center space-x-2 text-sm  text-gray-600 font-roboto p-5">
                <div class="w-1/2 space-y-2 text-sm  text-gray-600 font-roboto ">
                    <p>
                        Home Address: {{ data.homeAddress }}
                    </p>
                    <p>
                        Contact Number: {{ data.contactNumber }}
                    </p>
                    <p>
                        Email Address: {{ data.emailAddress }}
                    </p>
                    <p>
                        Date of Birth: {{ data.dateOfBirth }}
                    </p>
                    <p>
                        Civil Status: {{ data.civilStatus }}
                    </p>
                    <p>
                        Religion: {{ data.religion }}
                    </p>
                    <p>
                        Age: {{ getAge(data.dateOfBirth) }}
                    </p>
                </div>
                <div class="w-1/2 space-y-2 text-sm  text-gray-600 font-roboto ">
                    <p>
                        Gender: {{ data.gender }}
                    </p>
                    <p>
                        Major/Specialization: {{ data.majorSpecialization }}
                    </p>
                    <p>
                        Minor: {{ data.minor }}
                    </p>
                    <p>
                        Civil Service Eligibility: {{ data.civilServiceEligibility }}
                    </p>
                    <p>
                        Highest Education Attainment: {{ data.highestEducationAttainment }}
                    </p>
                    <p>
                        School Role: {{ data.schoolRole }}
                    </p>
                </div>
            </div>
            <div class="text-sm text-gray-600 font-roboto px-5 pt-3 space-y-2">
                <p class="font-semibold">Personnel Other Details</p>
                <div class="flex items-center space-x-2 ">
                    <div class="space-y-2 w-1/2">
                        <p>
                            GGIS BP NO.: {{ data.ggisbpno }}
                        </p>
                        <p>
                            TIN: {{ data.tin }}
                        </p>
                        <p>
                            Basic Salary: {{ data.basicSalary }}
                        </p>
                        <p>
                            Step Increment: {{ data.stepIncrement }}
                        </p>
                    </div>
                    <div class="space-y-2 w-1/2">
                        <p>
                            Height: {{ data.height }}
                        </p>
                        <p>
                            Weight: {{ data.weight }}
                        </p>
                        <p>
                            Contact Person in Case of Emergency: {{ data.contactPerson }}
                        </p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p>
                        Teaching Loads:
                    </p>
                    <div class="border p-2 shadow-md">
                        {{ data.teachingLoads }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
export default defineComponent({
    props: ["id"],
    components: {
        SearchOutlined,
    },
    // setup(){
    //     return {
    //         data: ref([])
    //     }
    // },
    data() {

        return {
            openLA: ref(false),
            value: '',
            data: {
                image: '',
                personnelRole: '',
                name: '',
                position: '',
                itemNumber: '',
                employeeNumber: '',
                dateOfBirth: '',
                dateLastProAppointment: '',
                datePermanency: '',
                dateOrigAppointment: '',
                homeAddress: '',
                contactNumber: '',
                gender: '',
                emailAddress: '',
                civilStatus: '',
                religion: '',
                majorSpecialization: '',
                minor: '',
                civilServiceEligibility: '',
                highestEducationAttainment: '',
                schoolRole: '',
                ggisbpno: '',
                tin: '',
                basicSalary: '',
                salaryGradeLevel: '',
                stepIncrement: '',
                height: '',
                weight: '',
                contactPerson: '',
                teachingLoads: '',
            },
            loading: ref(false),
            formValidateLA: {
                id: '',
                dateFiled: '',
                leaveCategory: '',
                noOfDays: '',
                dateOfLeave: '',
            },
            ruleValidateLA: {
                leaveCategory: [
                    { required: true, message: 'The Leave Category cannot be empty', trigger: 'blur' }
                ],
                dateFiled: [
                    { required: true, type: 'date', message: 'The Date Filed cannot be empty', trigger: 'blur' }
                ],
                noOfDays: [
                    { required: true, message: 'The No. of Days cannot be empty', trigger: 'blur' }
                ],
                dateOfLeave: [
                    { required: true, type: 'date', message: 'The Date of Leave cannot be empty', trigger: 'blur' }
                ],
            },
            leaveCategoryOptions: ref([{
                value: 'Vacation Leave (VL)',
                label: 'Vacation Leave (VL)',
            }, {
                value: 'Sick Leave (SL)',
                label: 'Sick Leave (SL)',
            }, {
                value: 'Special Leave Privileges (SLP)',
                label: 'Special Leave Privileges (SLP)',
            }, {
                value: 'Maternity Leave',
                label: 'Maternity Leave',
            }, {
                value: 'Paternity Leave',
                label: 'Paternity Leave',
            }, {
                value: 'Parental Leave for Solo Parents',
                label: 'Parental Leave for Solo Parents',
            }, {
                value: 'Rehabilitation Leave',
                label: 'Rehabilitation Leave',
            }, {
                value: 'Study Leave',
                label: 'Study Leave',
            }, {
                value: 'Terminal Leave',
                label: 'Terminal Leave',
            }]),
            openCP: ref(false),
            formValidateCP: {
                passwd: '',
                passwdCheck: ''
            },
            ruleValidateCP: {
                leaveCategory: [
                    { required: true, message: 'The Leave Category cannot be empty', trigger: 'blur' }
                ],
                dateFiled: [
                    { required: true, type: 'date', message: 'The Date Filed cannot be empty', trigger: 'blur' }
                ],
                noOfDays: [
                    { required: true, message: 'The No. of Days cannot be empty', trigger: 'blur' }
                ],
                dateOfLeave: [
                    { required: true, type: 'date', message: 'The Date of Leave cannot be empty', trigger: 'blur' }
                ],
            },
        }
    },

    methods: {
        getAge(birthday) {
            const today = new Date();
            const birthDate = new Date(birthday);
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        },
        async handleOkLA(name) {
            const thiss = this

            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            thiss.formValidateLA.id = thiss.id
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/storeLeaveApplication`, this.formValidateLA, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Leave Request Submitted Successfully',
                            });
                            thiss.$emit("value-emitted", true); // Emit the value
                            thiss.openLA = false
                        })
                        .catch(function (error) {

                        });

                } else {

                }
            })
        },
        async handleOkCP(name) {
            const thiss = this
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            thiss.formValidateCP.id = thiss.id
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/updatePersonnelAccountPassword`, this.formValidateCP, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Password Successfully Changed',
                            });
                            thiss.$emit("value-emitted", true); // Emit the value
                            thiss.openCP = false
                        })
                        .catch(function (error) {

                        });

                } else {

                }
            })
        },
    },
    async mounted() {
        const thiss = this
        const headers = {
            Authorization: `Bearer ${localStorage.getItem('authToken')}`,
        };
        try {
            const response = await axios.get(`/api/admin/getOnePersonnel/${this.id}`, { headers });
            // Map the data to the expected format for DataTables
            Object.keys(this.data).forEach((key) => {
                this.data[key] = response.data[0][key] || '';
            });

        } catch (error) {
            console.error('Error fetching data:', error);
        }

    },
    created() {
        const thiss = this
        this.token = localStorage.getItem('authToken')

    }
});
</script>

<style></style>
