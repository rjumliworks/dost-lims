<template>
    <Head title="Customer Insights"/>
    <PageHeader title="Customer Insights" pageTitle="Menu" />
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg="12">
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" placeholder="Search Request" class="form-control" style="width: 20%;">
                <!-- <Multiselect class="white" style="width: 15%;" :options="types" v-model="laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" /> -->
                <Multiselect v-if="by == 'By Semester'" class="white" style="width: 13%;" :options="semesters" v-model="semester" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect v-if="by == 'By Quarter'" class="white" style="width: 13%;" :options="quarters" v-model="quarter" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect v-if="by == 'By Month'" class="white" style="width: 13%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect class="white" style="width: 12%;" :options="['By Month','By Quarter','By Semester']" v-model="by" label="name" :allow-empty="false" :searchable="true" placeholder="Filter By" />
                <!-- <Multiselect class="white" style="width: 12%;" :options="['External','Internal']" v-model="customer" label="name" :allow-empty="false" :searchable="true" placeholder="Filter Customer" /> -->
                <Multiselect class="white" style="width: 15%;" :options="years" v-model="year" label="name" :searchable="true" placeholder="Select Year" />
                <b-button type="button" variant="primary"> Filter Data </b-button>
            </div>
        </b-col>
    </b-row>
    <hr class="text-muted"/>
    <BRow class="g-3" style="height: calc(100vh - 300px); overflow: auto;">
        
    </BRow>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['years','year'],
    components: { PageHeader, Multiselect },
    data(){
        return {
            by: null,
            year: this.year,
            month: null,
            quarter: null,
            semester: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            quarters: ['1st Quater','2nd Quarter','3rd Quarter','4th Quarter'],
            semesters: ['1st Semester','2nd Semester'],
        }
    },
    watch: {
        
    },
    created(){
        
    },
    methods: {
       
    }
}
</script>