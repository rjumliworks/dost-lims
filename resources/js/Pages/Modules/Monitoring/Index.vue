<template>
    <Head title="Monitoring"/>
    <PageHeader title="Monitoring" pageTitle="List" />
    <BRow>
        
    </BRow>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                laboratory: null
            },
            index: null,
            selectedRow: null
        }
    },
    methods: {
       
    }
}
</script>
