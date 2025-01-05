<template>
    <div class="w-full flex justify-center">
        <a-modal v-model:open="open" title="Edit Personnel" width="1000px" style="top: 20px" :maskClosable="false"
            @ok="handleOk('formValidate')" @cancel="onExit">
            <template #footer>
                <a-button key="submit" class="bg-gray-200 mb-2" :loading="loading"
                    @click="handleOk('formValidate')">Update</a-button>
            </template>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top"
                class="py-5 space-y-3">
                <div class="flex w-full space-x-5">
                    <div class="w-2/3 rounded bg-gray-100 p-2">
                        <FormItem label="Personnel Image" prop="image">
                            <Upload class="" type="drag" ref="uploads" :headers="{ 'Authorization': `Bearer ${token}` }"
                                :on-success="handleSuccess" :on-error="handleError" :format="['jpg', 'jpeg', 'png']"
                                :on-format-error="handleFormatError" action="/api/admin/uploadPersonnelImage">
                                <div style="padding: 18px 0">
                                    <Icon type="ios-cloud-upload" size="40" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <!-- src="/img/slides/Slide3Mobile.png" -->
                            <ImagePreview v-model="visiblePreview"
                                :preview-list="[`/img/personnel/${formValidate.image}`]" />
                            <div v-if="formValidate.image" class="demo-upload-list">
                                <Image :src="`/img/personnel/${formValidate.image}`" fit="cover" width="100%"
                                    height="100%" />
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-eye-outline" @click="handleView()"></Icon>
                                    <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                                </div>
                            </div>
                        </FormItem>
                    </div>
                    <div class="w-2/3 rounded bg-gray-100 p-2">
                        <p class="text-lg">
                            Authentication and Access
                        </p>
                        <FormItem label="Personnel Role" prop="role_id" class="p-0  mt-5">
                            <Select v-model="formValidate.role_id" style="width:100%"
                                placeholder="Personnel Role">
                                <Option v-for="item in roleOptions" :value="item.value" :key="item.value">{{
                                    item.label }}</Option>
                            </Select>
                        </FormItem>

                    </div>
                </div>
                <div class="flex w-full space-x-5">
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Personal Information
                        </p>
                        <FormItem label="Name" prop="name">
                            <Input v-model="formValidate.name" placeholder="Enter Full Name"></Input>
                        </FormItem>
                        <FormItem label="Gender" prop="gender" class="p-0">
                            <Select v-model="formValidate.gender" style="width:100%" placeholder="Gender">
                                <Option v-for="item in genderOptions" :value="item.value" :key="item.value">{{
                                    item.label }}</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Civil Status" prop="civilStatus" class="p-0">
                            <Select v-model="formValidate.civilStatus" style="width:100%" placeholder="Civil Status">
                                <Option v-for="item in civilStatusOptions" :value="item.value" :key="item.value">{{
                                    item.label }}</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Date of Birth" prop="dateOfBirth">
                            <DatePicker style="width:100%" type="date" placeholder="Select date"
                                v-model="formValidate.dateOfBirth">
                            </DatePicker>
                        </FormItem>
                        <FormItem label="Religion" prop="religion">
                            <Input v-model="formValidate.religion" placeholder="Enter Religion"></Input>
                        </FormItem>
                        <FormItem label="Height" prop="height">
                            <Input v-model="formValidate.height" placeholder="Enter Height"></Input>
                        </FormItem>
                        <FormItem label="Weight" prop="weight">
                            <Input v-model="formValidate.weight" placeholder="Enter Weight"></Input>
                        </FormItem>
                    </div>
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Employment Information
                        </p>
                        <FormItem label="Position" prop="position">
                            <Input v-model="formValidate.position" placeholder="Enter Personnel Position"></Input>
                        </FormItem>
                        <FormItem label="Item Number" prop="itemNumber">
                            <Input v-model="formValidate.itemNumber" placeholder="Enter Item Number"></Input>
                        </FormItem>
                        <FormItem label="Employee Number" prop="employeeNumber">
                            <Input v-model="formValidate.employeeNumber" placeholder="Enter Employee Number"></Input>
                        </FormItem>
                        <FormItem label="Data of Permanency" prop="datePermanency">
                            <DatePicker style="width:100%" type="date" placeholder="Select date"
                                v-model="formValidate.datePermanency"></DatePicker>
                        </FormItem>
                        <FormItem label="Date of Original Appointment" prop="dateOrigAppointment">
                            <DatePicker style="width:100%" type="date" placeholder="Select date"
                                v-model="formValidate.dateOrigAppointment"></DatePicker>
                        </FormItem>
                        <FormItem label="Date of Last Promotion/Appointment" prop="dateLastProAppointment">
                            <DatePicker style="width:100%" type="date" placeholder="Select date"
                                v-model="formValidate.dateLastProAppointment"></DatePicker>
                        </FormItem>
                        <FormItem label="School Role" prop="schoolRole" class="p-0">
                            <Select v-model="formValidate.schoolRole" style="width:100%" placeholder="School Role">
                                <Option v-for="item in schoolRoleOptions" :value="item.value" :key="item.value">{{
                                    item.label }}</Option>
                            </Select>
                        </FormItem>
                    </div>
                </div>
                <div class="flex w-full space-x-5">
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Contact Information
                        </p>
                        <FormItem label="Home Address" prop="homeAddress">
                            <Input v-model="formValidate.homeAddress" placeholder="Enter Home Address"></Input>
                        </FormItem>
                        <FormItem label="Contact Number" prop="contactNumber">
                            <Input v-model="formValidate.contactNumber" placeholder="Enter Contact Number"></Input>
                        </FormItem>
                        <FormItem label="Email Address" prop="emailAddress">
                            <Input v-model="formValidate.emailAddress" placeholder="Enter Email Address"></Input>
                        </FormItem>
                        <FormItem label="Contact Person" prop="contactPerson">
                            <Input v-model="formValidate.contactPerson" placeholder="Enter Contact Person"></Input>
                        </FormItem>
                    </div>
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Financial Information
                        </p>
                        <FormItem label="Basic Salary" prop="basicSalary">
                            <Input v-model="formValidate.basicSalary" placeholder="Enter Basic Salary"></Input>
                        </FormItem>
                        <FormItem label="Salary Grade Level" prop="salaryGradeLevel">
                            <Input v-model="formValidate.salaryGradeLevel"
                                placeholder="Enter Salary Grade Level"></Input>
                        </FormItem>
                        <FormItem label="Step Increment" prop="stepIncrement">
                            <Input v-model="formValidate.stepIncrement" placeholder="Enter Step Increment"></Input>
                        </FormItem>
                        <FormItem label="GGIS BP NO." prop="ggisbpno">
                            <Input v-model="formValidate.ggisbpno" placeholder="Enter GGIS BP NO."></Input>
                        </FormItem>
                        <FormItem label="TIN NO." prop="tin">
                            <Input v-model="formValidate.tin" placeholder="Enter TIN NO."></Input>
                        </FormItem>
                    </div>
                </div>
                <div class="flex w-full space-x-5">
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Educational Background
                        </p>
                        <FormItem label="Highest Education Attainment" prop="highestEducationAttainment">
                            <Input v-model="formValidate.highestEducationAttainment"
                                placeholder="Enter Highest Education Attainment"></Input>
                        </FormItem>
                        <FormItem label="Major/Specialization" prop="majorSpecialization">
                            <Input v-model="formValidate.majorSpecialization"
                                placeholder="Enter Major/Specialization"></Input>
                        </FormItem>
                        <FormItem label="Minor" prop="minor">
                            <Input v-model="formValidate.minor" placeholder="Enter Minor"></Input>
                        </FormItem>
                    </div>
                    <div class="w-2/3 space-y-5 rounded bg-gray-100 p-2 py-4">
                        <p class="text-lg">
                            Professional Qualifications
                        </p>
                        <FormItem label="Civil Service Eligibility" prop="civilServiceEligibility">
                            <Input v-model="formValidate.civilServiceEligibility"
                                placeholder="Enter Civil Service Eligibility"></Input>
                        </FormItem>
                        <FormItem label="Teaching Loads" prop="teachingLoads">
                            <Input v-model="formValidate.teachingLoads" placeholder="Enter Teaching Loads"></Input>
                        </FormItem>
                    </div>

                </div>
            </Form>
        </a-modal>
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
    data() {
        return {
            roleOptions: ref([{
                value: 1,
                label: 'Admin',
            }, {
                value: 2,
                label: 'Personnel',
            }]),
            genderOptions: ref([{
                value: 'Male',
                label: 'Male',
            }, {
                value: 'Female',
                label: 'Female',
            }]),
            schoolRoleOptions: ref([{
                value: 'School Head',
                label: 'School Head',
            }, {
                value: 'Adviser',
                label: 'Adviser',
            }]),
            civilStatusOptions: ref([{
                value: 'Single',
                label: 'Single',
            }, {
                value: 'Married',
                label: 'Married',
            },
            {
                value: 'Separated',
                label: 'Separated',
            },
            {
                value: 'Annulled',
                label: 'Annulled',
            },
            {
                value: 'Divorced',
                label: 'Divorced',
            },
            {
                value: 'Widowed',
                label: 'Widowed',
            }]),
            loading: ref(false),
            open: ref(true),

            token: '',
            visiblePreview: false,
            formValidate: {
                id: '',
                image: '',
                role_id: '',
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
            ruleValidate: {
                image: [
                    { required: true, message: 'The image cannot be empty', trigger: 'blur' }
                ],
                role_id: [
                    { required: true, message: 'The Personnel Role cannot be empty', trigger: 'blur' }
                ],
                name: [
                    { required: true, message: 'The Name cannot be empty', trigger: 'blur' }
                ],
                position: [
                    { required: true, message: 'The Position cannot be empty', trigger: 'blur' }
                ],
                itemNumber: [
                    { required: true, message: 'The Item Number cannot be empty', trigger: 'blur' }
                ],
                employeeNumber: [
                    { required: true, message: 'The Employee Number cannot be empty', trigger: 'blur' }
                ],
                dateOfBirth: [
                    { required: true, type: 'date', message: 'The Date of Birth cannot be empty', trigger: 'blur' }
                ],
                datePermanency: [
                    { required: true, type: 'date', message: 'The Date of Permanency cannot be empty', trigger: 'blur' }
                ],
                dateOrigAppointment: [
                    { required: true, type: 'date', message: 'The Date of Original Appointment cannot be empty', trigger: 'blur' }
                ],
                dateLastProAppointment: [
                    { required: true, type: 'date', message: 'The Date of Last Promotion/Appointment cannot be empty', trigger: 'blur' }
                ],
                homeAddress: [
                    { required: true, message: 'The Home Address cannot be empty', trigger: 'blur' }
                ],
                contactNumber: [
                    { required: true, message: 'The Contact Number cannot be empty', trigger: 'blur' }
                ],
                emailAddress: [
                    { required: true, message: 'The Email Address cannot be empty', trigger: 'blur' }
                ],
                civilStatus: [
                    { required: true, message: 'The Civil Status cannot be empty', trigger: 'blur' }
                ],
                religion: [
                    { required: true, message: 'The Religion cannot be empty', trigger: 'blur' }
                ],
                majorSpecialization: [
                    { required: true, message: 'The Major/Specialization cannot be empty', trigger: 'blur' }
                ],
                minor: [
                    { required: true, message: 'The Minor cannot be empty', trigger: 'blur' }
                ],
                civilServiceEligibility: [
                    { required: true, message: 'The Civil Service Eligibility cannot be empty', trigger: 'blur' }
                ],
                highestEducationAttainment: [
                    { required: true, message: 'The Highest Education Attainment cannot be empty', trigger: 'blur' }
                ],
                schoolRole: [
                    { required: true, message: 'The School Role cannot be empty', trigger: 'blur' }
                ],
                ggisbpno: [
                    { required: true, message: 'The GGIS BP NO. cannot be empty', trigger: 'blur' }
                ],
                tin: [
                    { required: true, message: 'The TIN NO. cannot be empty', trigger: 'blur' }
                ],
                basicSalary: [
                    { required: true, message: 'The Basic Salary cannot be empty', trigger: 'blur' }
                ],
                salaryGradeLevel: [
                    { required: true, message: 'The Salary Grade Level cannot be empty', trigger: 'blur' }
                ],
                stepIncrement: [
                    { required: true, message: 'The Step Increment cannot be empty', trigger: 'blur' }
                ],
                height: [
                    { required: true, message: 'The Height cannot be empty', trigger: 'blur' }
                ],
                weight: [
                    { required: true, message: 'The Weight cannot be empty', trigger: 'blur' }
                ],
                contactPerson: [
                    { required: true, message: 'The Contact Person cannot be empty', trigger: 'blur' }
                ],
                teachingLoads: [
                    { required: true, message: 'The Teaching Loads cannot be empty', trigger: 'blur' }
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
            thiss.formValidate.role_id = thiss.formValidate.role_id.toString();
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/updatePersonnel`, this.formValidate, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Personnel is Successfully Updated',
                            });
                            thiss.open = false
                            thiss.$emit("value-emitted", false); // Emit the value
                        })
                        .catch(function (error) {

                        });

                } else {

                }
            })

        },
        onExit() {
            const thiss = this
            thiss.$emit("value-emitted", false); // Emit the value
        },
        handleSuccess(res, file) {
            this.formValidate.image = res
            console.log('res: ', res);
            console.log('file: ', file);
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
        handleView() {
            this.visiblePreview = true;
        },
        deleteImage() {
            let image = this.formValidate.image
            this.formValidate.image = ''
            this.$refs.uploads.clearFiles()
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deletePeronnelImage`, { imageName: image }, { headers })
                .then(function (response) {
                })
                .catch(function (error) {
                    if (error) {
                        this.formValidate.image = image
                    }
                });
        },
    },
    async mounted() {
        const thiss = this

        this.token = localStorage.getItem('authToken')
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };

        await axios.get(`/api/admin/getOnePersonnel/${thiss.id}`, { headers })
            .then(function (response) {
                const personnelData = response.data[0];
                Object.keys(personnelData).forEach((key) => {
                    if (thiss.formValidate.hasOwnProperty(key)) {
                        thiss.formValidate[key] = personnelData[key] || '';
                    }
                });

                console.log(thiss.formValidate);
            })
            .catch(function (error) {
                console.log(error)
            });
    }
});
</script>

<style>
.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    margin-right: 4px;
}

.demo-upload-list img {
    width: 100%;
    height: 100%;
}

.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, .6);
}

.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}

.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
