<template>
    <div class="w-full flex justify-around space-x-5">
        <div class="w-3/5">
            <div class="flex justify-between items-center">
                <p class="text-blue-900 font-semibold blur-none tracking-wide antialiased font-roboto text-base">
                    201 Files Management
                </p>

            </div>
            <div class="border-2 border-gray-300 space-y-5 rounded p-2 w-full">
                <div class="flex w-full justify-center items-center">
                    <div class="w-2/4 mt-2">
                        <div>
                            <Input v-model="searchValue" autofocus search enter-button
                                placeholder="Search 201 Files here" @on-search="searchArticle()" />
                        </div>
                    </div>
                </div>
                <div v-if="files201.length === 0" class="p-5 border opacity-80 rounded text-center">
                    <p>The output of the search will be available in this area. Search now</p>
                </div>
                <div v-if="files201.length !== 0" class="p-5 border opacity-80 rounded">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                    Document Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="file in files201">
                                <td
                                    class="px-6 py-2 whitespace-nowrap border-b border-gray-300 cursor-pointer hover:underline">
                                    <a @click="downloadDocument(doc.id)">{{ file.fileName.replace(" - " +
                                        file.user.name, "") }}</a>

                                </td>
                                <td class="px-6 py-2 whitespace-nowrap border-b border-gray-300">
                                    <a @click="downloadDocument(file.id)">Download</a>
                                </td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Records',
    data() {
        return {
            // Your component data goes here
            files201: [],
            searchValue: null,
        };
    },
    methods: {
        // Your component methods go here
        async searchArticle() {
            const thiss = this;
            thiss.files201 = [];
            await axios.post('/api/admin/searchArticle', { search: thiss.searchValue })
                .then(function (response) {
                    thiss.files201 = response.data
                    console.log(response.data);
                })
                .catch(function (error) {

                });
        },
        downloadDocument(id) {
            const headers = {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`,
            };
            window.location.href = `/api/admin/downloadDocument/${id}?Authorization=${headers.Authorization}`;
        },
    },
    computed: {
        // Your computed properties go here
    },
    mounted() {
        // Your mounted lifecycle hook goes here
    }
});
</script>

<style scoped>
/* Your component styles go here */
</style>