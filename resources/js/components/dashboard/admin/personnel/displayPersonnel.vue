<template>
    <div class="w-full flex justify-center border bg-white drop-shadow p-2">
        <div class="w-full">
            <div class="flex  items-center">
                <div>
                    <!-- {{ data.image }} -->
                    <img class="object-cover w-full" :src="`/img/personnel/${data.image}`">
                    <div class="text-center font-semibold">
                        <p class="">
                            {{ data.name }}
                        </p>
                        <p class="border border-gray-500 bg-yellow-200">
                            {{ data.position }}
                        </p>
                    </div>
                </div>
                <div class="ml-2 w-full space-y-2 text-sm font-semibold text-gray-600 font-roboto ">
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
                <div>
                    <a-button class="bg-gray-200 mb-2" size="small">Other Details</a-button>
                    <a-button class="bg-gray-200 mb-2" size="small">Leave Credits</a-button>
                </div>
            </div>
            <div class="flex items center space-x-2 text-sm font-semibold text-gray-600 font-roboto p-5">
                <div class="w-1/2 space-y-2 text-sm font-semibold text-gray-600 font-roboto ">
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
                <div class="w-1/2 space-y-2 text-sm font-semibold text-gray-600 font-roboto ">
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
            }
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
        }
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
