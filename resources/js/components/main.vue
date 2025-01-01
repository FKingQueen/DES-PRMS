<template>
    <div class="w-full flex items-center justify-center" :style="minHeightStyle">

        <div class="w-1/4 ">
            <div class="pb-2">
                <p class="font-semibold text-start text-4xl">
                    DES – PRMS
                </p>
            </div>
            <div class="border block space-y-5 py-10 px-2">
                <div class="w-full flex justify-center">
                    <button @click="this.$router.push('/requestForm')" class="w-full p-2 bg-gray-100 rounded hover:bg-gray-200">Request Form</button>
                </div>
                <div class="w-full flex justify-center">
                    <button @click="this.$router.push('/login')" class="w-full p-2 bg-gray-100 rounded hover:bg-gray-200">Login</button>
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
            screenHeight: window.innerHeight - 100
        }
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
