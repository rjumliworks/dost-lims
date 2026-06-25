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
                        <Multiselect class="white" style="width: 15%;" :options="laboratories" v-model="laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Discount Insights</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="shadow-none">
                    <div class="table-responsive" style="margin-top: -1px; margin-bottom: 10px; height: calc(100vh - 350px); overflow: auto;">
                        <table class="table table-light table-bordered table-striped table-nowrap align-middle">
                            <thead class="thead-fixed text-primary fs-11">
                                <tr class="bg-dark">
                                    <th rowspan="3" class="text-center align-middle table-primary">No.</th>
                                    <th rowspan="3" class="align-middle table-primary">Customer Name</th>
                                    <th colspan="12" class="text-center align-middle table-info">Address / District</th>
                                    <th rowspan="2" colspan="2"  class="text-center align-middle table-success">Firm</th>
                                    <th colspan="5" class="text-center align-middle table-warning">Individual</th>
                                    <th rowspan="3" class="text-center align-middle table-danger">New</th>
                                </tr>
                                <tr class="text-center align-middle">
                                    <th rowspan="2" class="table-info" style="border: 1px solid red">IC</th>
                                    <th rowspan="2" class="table-info">Sulu</th>
                                    <th colspan="2" class="table-info">ZC</th>
                                    <th colspan="3" class="table-info">ZDN</th>
                                    <th colspan="2" class="table-info">ZDS</th>
                                    <th colspan="2" class="table-info">ZSP</th>
                                    <th rowspan="2" class="align-middle table-info">Outside</th>
                                    <th colspan="2" class="table-warning">Sex</th>
                                    <th colspan="3" class="table-warning">Status</th>
                                </tr>
                                <tr class="align-middle text-center">
                                    <th class="table-info">1st</th>
                                    <th class="table-info">2nd</th>
                                    <th class="table-info">1st</th>
                                    <th class="table-info">2nd</th>
                                    <th class="table-info">3rd</th>
                                    <th class="table-info">1st</th>
                                    <th class="table-info">2nd</th>
                                    <th class="table-info">1st</th>
                                    <th class="table-info">2nd</th>
                                    <th class="table-success">Paying</th>
                                    <th class="table-success">Non-Pay</th>
                                    <th class="table-warning">Male</th>
                                    <th class="table-warning">Female</th>
                                    <th class="table-warning">Student</th>
                                    <th class="table-warning">Senior</th>
                                    <th class="table-warning">PWD</th>
                                </tr>
                            </thead>
                            <tbody class="fs-10">
                                <tr style="cursor: pointer;" v-for="(item,index) in list" :key="`breakdown-${index}`">
                                    <td class="text-center">{{index+1}}</td>
                                    <td class="">{{item.name}}</td>
                                    <td class="text-center">
                                        <i v-if="item.ic" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.sulu" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zc1" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zc2" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zdn1" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zdn2" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                     <td class="text-center">
                                        <i v-if="item.zdn3" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zds1" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zds2" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zsp1" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.zsp2" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.outside" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.paying" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.nonpay" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.male" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.female" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.student" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.senior" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.pwd" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                    </td>
                                    <td class="text-center">
                                        <i v-if="item.isnew == 'yes'" class="text-success fs-16 ri-checkbox-circle-fill"></i>
                                        <i v-else-if="item.isnew == 'no'" class="text-danger fs-16 ri-close-circle-fill"></i>
                                        <i v-else class="text-warning fs-16 ri-close-circle-fill"></i>
                                        <!-- {{newCount}} / {{oldCount}} / {{oldNone}} -->
                                    </td>
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
    props: ['years','selected','laboratories'],
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
     computed: {
        newCount() {
            return this.list.filter(item => item.isnew == 'yes').length;
        },
        oldCount() {
            return this.list.filter(item => item.isnew == 'no').length;
        },
        oldNone() {
            return this.list.filter(item => item.isnew == 'none').length;
        }
    },
    methods: {
        fetch(){
            axios.get('/insights/customers',{
                params : {
                    month: this.month,
                    year: this.year,
                    option: 'location'
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
            window.open('/accomplishments?option=location&month='+this.month+'&year='+this.year+'&laboratory='+this.laboratory);
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