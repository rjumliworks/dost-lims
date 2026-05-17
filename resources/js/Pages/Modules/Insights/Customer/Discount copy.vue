<template lang="">
    <Head title="Target vs Accomplishment"/>
    <div class="auth-page-wrapper d-flex min-vh-100">
        <div class="auth-page-content">
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <div class="file-manager-content w-100 p-4 pb-0" ref="box">
                     <b-row class="mt-2">
                        <b-col lg>
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
                        </b-col>
                    </b-row>
                    <div class="table-responsive" style="margin-top: 5px; height: calc(100vh - 80px); overflow: auto;">
                        <table class="table table-light table-bordered table-striped table-nowrap align-middle">
                            <thead class="thead-fixed text-primary fs-11">
                                <tr class="bg-dark">
                                    <th rowspan="2" class="align-middle">No.</th>
                                    <th rowspan="2" class="text-center align-middle">TSR No.</th>
                                    <th rowspan="2" class="align-middle">Customer Name</th>
                                    <th rowspan="2" class="text-center align-middle">No. of Samples</th>
                                    <th rowspan="2" class="text-center align-middle">No. of Services</th>
                                    <th rowspan="2" class="text-center align-middle">Fees Collected</th>
                                    <th colspan="3"  class="text-center align-middle table-info">Gratis</th>
                                    <th colspan="5"  class="text-center align-middle table-danger">Discount</th>
                                    <th rowspan="2" class="text-center align-middle table-success">Grouss Amount</th>
                                </tr>
                                <tr class="text-center align-middle">
                                    <th class="table-info">Calibration</th>
                                    <th class="table-info">QC</th>
                                    <th class="table-info">R&D</th>
                                    <th class="table-danger">Health Units</th>
                                    <th class="table-danger">Student</th>
                                    <th class="table-danger">Senior Citizen</th>
                                    <th class="table-danger">PWD</th>
                                    <th class="table-danger">Women's</th>
                                
                                </tr>
                            </thead>
                            <tbody class="fs-10">
                                <tr style="cursor: pointer;" v-for="(item,index) in list" :key="`breakdown-${index}`">
                                    <td class="text-center">{{index+1}}</td>
                                    <td class="text-center">{{item.code}}</td>
                                    <td class="">{{item.name}}</td>
                                    <td class="text-center align-middle">{{item.samples}}</td>
                                    <td class="text-center align-middle">{{item.analyses}}</td>
                                    <td class="text-center align-middle">{{item.fees}}</td>
                                    <td class="text-center align-middle">{{item.calibration}}</td>
                                    <td class="text-center align-middle">{{item.qc}}</td>
                                    <td class="text-center align-middle">{{item.rd}}</td>
                                    <td class="text-center align-middle">{{item.health}}</td>
                                    <td class="text-center align-middle">{{item.student}}</td>
                                    <td class="text-center align-middle">{{item.senior}}</td>
                                    <td class="text-center align-middle">{{item.pwd}}</td>
                                    <td class="text-center align-middle">{{item.women}}</td>
                                    <td class="text-center align-middle">{{item.gross}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from "@vueform/multiselect";
export default {
    layout: null,
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
                    option: 'discount'
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
            window.open('/accomplishments?option=excel2&month='+this.month+'&year='+this.year+'&laboratory='+this.laboratory);
        },
        formatMoney(value) {
            let val = (value / 1).toFixed(2).replace(',', '.');
            return '₱' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    }
}
</script>
<style scoped>
.auth-page-wrapper .auth-page-content {
    padding-bottom: 0px;
  width: 100%;
  overflow: hidden;
  background-color: #f3f3f9;
}
.file-manager-sidebar {
  min-width: 24%;
  max-width: 24%;
  height: calc(100vh - 92px);
}
.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}
</style>
