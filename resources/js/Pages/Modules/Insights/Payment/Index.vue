<template>
    <Head title="Payment Insights"/>
    <PageHeader title="Payment Insights" pageTitle="Menu" />
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg="12">
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <Multiselect class="white" style="width: 20%;" :options="dropdowns.laboratories" v-model="laboratory" label="name" :searchable="true" placeholder="Select Laboratory" />
                <Multiselect class="white" :can-clear="false" :can-deselect="false" style="width: 15%;" :options="years" v-model="year" label="name" :searchable="true" placeholder="Select Year" />
                <b-button type="button" variant="primary" @click="fetch"> Filter Data </b-button>
            </div>
        </b-col>
    </b-row>
    <hr class="text-muted"/>
    <BRow class="g-3" style="height: calc(100vh - 300px); overflow: auto;">
        <BCol xl="8">
            <Bar :laboratory="laboratory" ref="bar"/>
        </BCol>
        <BCol xl="4">
            <Monitoring :collection="collection" :collection_summary="collection_summary" ref="monitoring"/>
        </BCol>
        <BCol xl="6" class="mt-n1">
            <Breakdown
            :lists="status"
            title="Payment Status Breakdown"
            description="Shows payment counts and amounts grouped by status"
            icon="ri-flag-2-fill"
            option="status"
            :current_year="current_year"
            :years="years"
            ref="status"/>
        </BCol>
        <BCol xl="6" class="mt-n1">
            <Breakdown
            :lists="type"
            title="Payment Type Breakdown"
            description="Shows payment counts and amounts grouped by payment mode"
            icon="ri-bank-card-fill"
            option="type"
            :current_year="current_year"
            :years="years"
            ref="type"/>
        </BCol>
        <BCol xl="6" class="mt-n1">
            <Breakdown
            :lists="discount_individual"
            title="Individual Discount Breakdown"
            description="Shows discount counts and amounts for individual customers"
            icon="ri-price-tag-3-fill"
            option="discount_individual"
            :current_year="current_year"
            :years="years"
            ref="discountIndividual"/>
        </BCol>
        <BCol xl="6" class="mt-n1">
            <Breakdown
            :lists="discount_firms"
            title="Firms Discount Breakdown"
            description="Shows discount counts and amounts for firm customers"
            icon="ri-price-tag-3-fill"
            option="discount_firms"
            :current_year="current_year"
            :years="years"
            ref="discountFirms"/>
        </BCol>
        <BCol xl="6" class="mt-n1">
            <Breakdown
            :lists="collection_breakdown"
            title="Collection Breakdown"
            description="Shows payment counts and amounts grouped by collection type"
            icon="ri-safe-2-fill"
            option="collection_breakdown"
            :current_year="current_year"
            :years="years"
            ref="collectionBreakdown"/>
        </BCol>
    </BRow>
</template>
<script>
import Bar from './Components/Bar.vue';
import Monitoring from './Components/Monitoring.vue';
import Breakdown from './Components/Breakdown.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['years','current_year','dropdowns'],
    components: { PageHeader, Multiselect, Bar, Monitoring, Breakdown },
    data(){
        return {
            year: this.current_year,
            laboratory: null,
            collection: [],
            collection_summary: [],
            status: [],
            type: [],
            discount_individual: [],
            discount_firms: [],
            collection_breakdown: [],
        }
    },
    watch: {
        "year"(newVal){
            this.fetch();
            this.$refs.bar.updateYear(newVal);
        },
        "laboratory"(){
            this.fetch();
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            axios.get('/insights/payments',{
                params : {
                    year: this.year,
                    laboratory: this.laboratory,
                    option: 'data'
                }
            })
            .then(response => {
                this.collection = response.data.collection;
                this.collection_summary = response.data.collection_summary;
                this.status = response.data.status;
                this.type = response.data.type;
                this.discount_individual = response.data.discount_individual;
                this.discount_firms = response.data.discount_firms;
                this.collection_breakdown = response.data.collection_breakdown;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
