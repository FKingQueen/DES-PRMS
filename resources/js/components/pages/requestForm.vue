<template>
    <div>
        <button @click="$router.go(-1)">
            Back
        </button>
    </div>
    <div class="w-full flex items-center justify-center" :style="minHeightStyle">

        <div class="w-1/4 ">
            <div>
                Request Form
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
