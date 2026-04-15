<template>
    <div class="table-responsive table-card" style="height: calc(100vh - 443px);">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="bg-primary text-white">
                <tr class="fs-10">
                    <th style="width: 4%;"></th>
                    <th>Supplier</th>
                    <th class="text-center" style="width: 7%;"></th>
                </tr>
            </thead>
            <tbody v-if="lists.length > 0">
               
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
import _ from 'lodash';
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
            filter : {
                keyword: null,
            }
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    created(){
        // this.fetch();
    },
    methods: {
         checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/inventory';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    option: 'stockout',
                    keyword : this.keyword,
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
    }
}
</script>