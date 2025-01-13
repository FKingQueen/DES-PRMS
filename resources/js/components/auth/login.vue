<template>
 <div 
    class="w-full flex items-center justify-center bg-cover bg-center bg-no-repeat h-screen" 
    :style="{ backgroundImage: 'url(/img/background/matatag.png)' }"
  >
        <div class="w-1/4 bg-white p-5">
            <div class="pb-2">
                <p @click="$router.push('/')"  class="font-semibold text-center text-4xl cursor-pointer">
                    DES – PRMS
                </p>
            </div>
            <div>
                <p class="text-start pl-2 text-base">
                    User Login
                </p>
            </div>
            <div class="w-full border rounded">
                <div class="pt-4 pb-0 px-4">
                    <Form ref="loginForm" :model="loginForm" :rules="ruleInline" label-position="top">
                        <FormItem label="Employee Number" prop="employeeNumber" class="w-full">
                            <Input type="text" v-model="loginForm.employeeNumber" placeholder="Employee Number">
                            <template #prepend>
                                <Icon type="ios-person-outline"></Icon>
                            </template>
                            </Input>
                        </FormItem>
                        <FormItem label="Password" prop="password" class="w-full">
                            <Input type="password" v-model="loginForm.password" placeholder="Password">
                            <template #prepend>
                                <Icon type="ios-lock-outline"></Icon>
                            </template>
                            </Input>
                        </FormItem>
                        <FormItem class="w-full flex justify-end">
                            <Button type="primary" @click="handleSubmit('loginForm')">Login</Button>
                        </FormItem>
                    </Form>
                </div>
                <div class="text-center">
                    <p>
                        "Fostering relevant, resilient and equitable education Through DES (Dedicated and Efficient Service)"                    </p>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { defineComponent, ref, reactive, computed } from 'vue';
import { mapActions } from 'vuex';

export default defineComponent({
    data() {
        return {
            loginForm: {
                employeeNumber: '',
                password: ''
            },
            ruleInline: {
                employeeNumber: [
                    { required: true, message: 'Please fill in the user name', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: 'Please fill in the password.', trigger: 'blur' },
                ]
            },
            screenHeight: window.innerHeight - 100,

        }
    },
    methods: {
        ...mapActions(['login']), // This maps the login action
        handleSubmit(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    this.login({  // Now this.login should be available
                        employeeNumber: this.loginForm.employeeNumber,
                        password: this.loginForm.password
                    })
                } else {

                }
            })
        }
    },
    computed: {
        minHeightStyle() {
            return {
                minHeight: `${this.screenHeight}px`
            }
        },
        backgroundStyle() {
            return {
                backgroundImage: "url('/img/background/matatag.png')",
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat'
            }
        }
    }
});
</script>

<style scoped></style>
