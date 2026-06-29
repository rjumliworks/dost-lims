<template lang="">
    <Head title="Discount Insights"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" placeholder="Accomplishments" class="form-control" style="width: 40%;">
                        <Multiselect class="white" style="width: 15%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                        <Multiselect class="white" style="width: 15%;" :options="years" v-model="year" label="name" :allow-empty="false" :searchable="true" placeholder="Select Year" />
                            <b-button type="button" variant="light" @click="openExcel()">
                            Download Excel
                        </b-button>
                        <b-button type="button" variant="primary" @click="openCreate">
                            <i class="ri-search-eye-fill align-bottom"></i>
                        </b-button>
                    </div>
                </b-card-body>
            </b-card>
        </div>
        <b-col lg="12" class="mt-n2">
            <div class="card shadow-none">
                <div class="card-header border bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-alarm-warning-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Customers Requesting</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="shadow-none">
                    <div class="table-responsive" style="margin-top: -1px; margin-bottom: 10px; height: calc(100vh - 350px); overflow: auto;">
                        <table class="table table-bordered table-striped table-nowrap align-middle">
                            <thead class="thead-fixed text-primary fs-11">
                                <tr class="bg-dark">
                                    <th style="width: 4%;" rowspan="2" class="text-center align-middle table-primary">No.</th>
                                    <th style="width: 10%;" rowspan="2" class="text-center align-middle table-primary">Laboratory</th>
                                    <th colspan="4" class="text-center align-middle table-success">Number of Clients Served Requested Lab test(s)</th>
                                </tr>
                                <tr class="text-center align-middle">
                                    <th class="table-info" style="width: 15%;">At least once a month</th>
                                    <th class="table-info" style="width: 15%;">At least once every three months</th>
                                    <th class="table-info" style="width: 15%;">At least once every six months</th>
                                    <th class="table-info" style="width: 15%;">At least once ina year</th>
                                
                                </tr>
                            </thead>
                            <tbody class="fs-10">
                                <tr style="cursor: pointer;" v-for="(item,index) in list" :key="`breakdown-${index}`">
                                    <td class="text-center">{{index+1}}</td>
                                    <td class="text-center">{{item.code}}</td>
                                    <td class="text-center align-middle">1</td>
                                    <td class="text-center align-middle">2</td>
                                    <td class="text-center align-middle">3</td>
                                    <td class="text-center align-middle">4</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </b-col>
    </b-row>
</template>
<script>
import Multiselect from "@vueform/multiselect";
export default {
    components: { Multiselect },
    props: ['years','selected'],
    data(){
        return {
            selectedRow: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            years: this.years,
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            laboratory: null,
            selectedRow: null, 
            selectedColumn: null,
            expandedRows: {},
            list: []
        }
    },
    created(){
        this.fetch();
    },
    watch: {
        'year'(){
            this.fetch();
        },
        'month'(){
            this.fetch();
        },
        'laboratory'(){
            this.fetch();
        },
    },
    methods: {
        fetch(){
            axios.get('/insights/customers',{
                params : {
                    month: this.month,
                    year: this.year,
                    laboratory: this.laboratory,
                    option: 'request'
                }
            })
            .then(response => {
                this.list = response.data;
            })
            .catch(err => console.log(err));
        },
        toggleRow(index) {
           this.expandedRows[index] = !this.expandedRows[index];
        },
        selectRow(index) {
            this.selectedRow = (this.selectedRow == index) ? null : index;
        },
        selectColumn(index) {
            this.selectedColumn = (this.selectedColumn == index) ? null : index;
        },
        openExcel(){
            window.open('/accomplishments?option=discount&month='+this.month+'&year='+this.year+'&laboratory='+this.laboratory);
        },
        formatMoney(value) {
            let val = (value / 1).toFixed(2).replace(',', '.');
            return '₱' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    }
}
</script>

<style scoped>
.table-bordered th {
  border: 1px solid #dee2e6;
}
</style>