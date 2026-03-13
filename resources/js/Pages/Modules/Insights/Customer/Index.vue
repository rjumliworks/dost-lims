<template>
    <Head title="Customer Insights"/>
    <PageHeader title="Customer Insights" pageTitle="Menu" />
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg="12">
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" placeholder="Search Customer" class="form-control" style="width: 20%;">
                <!-- <Multiselect class="white" style="width: 15%;" :options="types" v-model="laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" /> -->
                <Multiselect v-if="by == 'By Semester'" class="white" style="width: 13%;" :options="semesters" v-model="semester" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect v-if="by == 'By Quarter'" class="white" style="width: 13%;" :options="quarters" v-model="quarter" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect v-if="by == 'By Month'" class="white" style="width: 13%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect class="white" style="width: 12%;" :options="['By Month','By Quarter','By Semester']" v-model="by" label="name" :allow-empty="false" :searchable="true" placeholder="Filter By" />
                <!-- <Multiselect class="white" style="width: 12%;" :options="['External','Internal']" v-model="customer" label="name" :allow-empty="false" :searchable="true" placeholder="Filter Customer" /> -->
                <Multiselect class="white" :can-clear="false" :can-deselect="false"  style="width: 15%;" :options="years" v-model="year" label="name" :searchable="true" placeholder="Select Year" />
                <b-button type="button" variant="primary"> Filter Data </b-button>
            </div>
        </b-col>
    </b-row>
    <hr class="text-muted"/>
    <BRow class="g-3" style="height: calc(100vh - 300px); overflow: auto;">
        <BCol xl="8">
            <Bar ref="bar"/>
        </BCol>
        <BCol xl="4">
            <Summary :count="summary_count" :type="summary_type" ref="summary"/>
        </BCol>
    </BRow>
</template>
<script>
import Bar from './Components/Bar.vue';
import Summary from './Components/Summary.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['years','year'],
    components: { PageHeader, Multiselect, Bar, Summary },
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
            summary_count: [],
            summary_type: []
        }
    },
    watch: {
        
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            axios.get('/insights/customers',{
                params : {
                    month: this.month,
                    year: this.year,
                    semester: this.semester,
                    quarter: this.quarter,
                    by: this.by,
                    option: 'data'
                }
            })
            .then(response => {
                this.summary_count = response.data.summary_count;
                this.summary_type = response.data.summary_type;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>