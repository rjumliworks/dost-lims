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
                                    <th rowspan="3" class="align-middle">No.</th>
                                    <th rowspan="3" class="align-middle">Customer Name</th>
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
                                        {{newCount}} / {{oldCount}} / {{oldNone}}
                                    </td>
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
    props: ['years','selected'],
    data(){
        return {
            selectedRow: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            years: this.years,
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            selectedRow: null, 
            selectedColumn: null,
            expandedRows: {},
            list: []
        }
    },
    created(){
        this.fetch();
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
            window.open('/accomplishments?option=excel&month='+this.month+'&year='+this.year);
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
