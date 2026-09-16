<template>
    <div class="table-responsive table-card" style="height: calc(100vh - 443px);">
        <table class="table table-nowrap align-middle mb-0">
           <thead class="bg-primary text-white thead-fixed">
                <tr class="fs-11">
                    <th style="width: 4%;"></th>
                    <th style="width: 13%;">Type</th>
                    <th>Old Name</th>
                    <th>New Name</th>
                    <th style="width: 17%;" class="text-center">User</th>
                    <th style="width: 20%;" class="text-center">Date</th>
                </tr>
            </thead>
            <tbody v-if="lists.length > 0">
                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                    <td>
                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                    </td>
                    <td>
                        <span class="badge fs-11" :class="list.log_name == 'Name' ? 'bg-info-subtle text-info' : 'bg-secondary-subtle text-secondary'">
                            {{ list.log_name == 'Name' ? 'Main Name' : 'Branch Name' }}
                        </span>
                    </td>
                    <td class="text-muted">{{ list.properties?.old?.name ?? '—' }}</td>
                    <td class="fw-semibold">{{ list.properties?.attributes?.name ?? '—' }}</td>
                    <td class="text-center">{{list.causer.profile.fullname}} </td>
                    <td class="text-center">{{formatDate(list.created_at)}}</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6" class="text-center text-muted">No records found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer" style="margin-left: -15px; margin-right: -15px;">
        <Pagination class="ms-2 me-2 mt-n1 mb-n3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
</template>
<script>
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination },
    props: ['id'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(page_url) {
            page_url = page_url || '/customers';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    option: 'changelogs',
                    count: 10
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        formatDate(dateString) {
            const date = new Date(dateString)

            return date.toLocaleString('en-PH', {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
            })
        }
    }
}
</script>
