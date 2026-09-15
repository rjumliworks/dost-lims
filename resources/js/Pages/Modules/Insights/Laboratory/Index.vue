<template>
    <Head title="Laboratory Insights"/>
    <PageHeader title="Laboratory Insights" pageTitle="Menu" />
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
            <Breakdown ref="breakdown"/>
        </BCol>
        <BCol xl="4">
            <Summary :summary="summary" ref="summary"/>
        </BCol>
    </BRow>
</template>
<script>
import Breakdown from './Components/Breakdown.vue';
import Summary from './Components/Summary.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['years','current_year','dropdowns'],
    components: { PageHeader, Multiselect, Breakdown, Summary },
    data(){
        return {
            year: this.current_year,
            laboratory: null,
            summary: [],
        }
    },
    watch: {
        "year"(newVal){
            this.fetch();
            this.$refs.breakdown.updateYear(newVal);
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
            axios.get('/insights/laboratories',{
                params : {
                    year: this.year,
                    laboratory: this.laboratory,
                    option: 'data'
                }
            })
            .then(response => {
                this.summary = response.data.summary;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
