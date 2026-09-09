<template>
<div class="table-responsive table-card" style="height: calc(100vh - 419px);">
    <table class="table align-middle table-striped table-centered mb-0">
        <thead class="bg-primary text-white thead-fixed">
            <tr class="fs-11">
                <th style="width: 4%;"></th>
                <th>TSR Code</th>
                <th>Customer</th>
                <th class="text-center" style="width: 15%;">Laboratory</th>
                <th class="text-center" style="width: 17%;">Date Requested</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th style="width: 5%;"></th>
            </tr>
        </thead>
        <tbody class="table-white fs-12" v-if="lists.length > 0">
            <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                <td>
                    {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                </td>
                <td>
                    <h5 v-if="list.code" class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                    <h5 v-else class="fs-13 mb-0 text-muted">Not yet available</h5>
                </td>
                <td>{{list.customer}}</td>
                <td class="text-center">{{list.laboratory?.name}}</td>
                <td class="text-center">{{list.created_at}}</td>
                <td class="text-center">
                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                </td>
                <td>
                    <a :href="`/tsrs/${list.reference}`" target="_blank">
                        <b-button variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                            <i class="ri-eye-fill align-bottom"></i>
                        </b-button>
                    </a>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="7" class="text-center text-muted">No TSRs found using this test service.</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="card-footer me-n3 ms-n3">
    <Pagination class="ms-2 me-2 mt-n1 mb-n3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
</div>
</template>
<script>
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination },
    props:['id'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
        }
    },
    created(){
        this.fetch();
    },
    methods : {
        fetch(page_url){
            page_url = page_url || '/testservices';
            return axios.get(page_url,{
                params : {
                    id: this.id,
                    option: 'tsrs',
                    count: ((window.innerHeight-490)/50),
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            });
        }
    }
}
</script>
