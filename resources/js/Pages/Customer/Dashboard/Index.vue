<template>
    <PageHeader title="Dashboard" pageTitle="Customer" />
    <b-row class="g-3">
        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>

                </b-card-body>
            </b-card>
        </div>

        <div class="col-md-3 mt-n1">

        </div>

        <div class="col-md-6 mt-n1">
            <div class="row g-3">
                <b-col lg="4" v-for="(item, index) of counts" :key="index">
                    <b-card no-body :class="item.color" class="border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-5">
                                        <i :class="`${item.icon} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </div>
        </div>

        <div class="col-md-3 mt-n1">

        </div>

    </b-row>
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader },
    data() {
        return {
            filter: {
                keyword: null,
                type: 'Daily',
                laboratory: null,
                date: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            counts: []
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            axios.get('/fetch',{
                params : {
                    year: this.filter.year,
                    month: this.monthName,
                    laboratory: this.filter.laboratory,
                    option: 'labhead',
                }
            })
            .then(response => {
                this.counts = response.data.counts; 
            })
            .catch(err => console.log(err));
        },
    },
}
</script>