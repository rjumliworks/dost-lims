<template lang="">
    <Head title="Discount Insights"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" placeholder="Accomplishments" class="form-control" style="width: 20%;">
                        <Multiselect class="white" style="width: 15%;" :options="discounts" v-model="discount" label="name" :allow-empty="false" :searchable="true" placeholder="Select Discount" />
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
                        <table class="table table-bordered table-striped table-nowrap align-middle">
                            <thead class="thead-fixed text-primary fs-11">
                                <tr class="">
                                    <th class="text-center align-middle table-primary">No.</th>
                                    <th class="text-center align-middle table-primary">TSR No.</th>
                                    <th class="align-middle table-primary">Customer Name</th>
                                    <th class="text-center align-middle table-primary">No. of Samples</th>
                                    <th class="text-center align-middle table-primary">No. of Services</th>
                                    <th class="text-center align-middle table-primary">Fees Collected</th>
                                    <th class="text-center align-middle table-danger">Discount</th>
                                    <th class="text-center align-middle table-success">Grouss Amount</th>
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
                                    <td class="text-center align-middle">{{item.discount}}</td>
                                    <td class="text-center align-middle">{{item.gross}}</td>
                                </tr>
                            </tbody>
                            <tfoot class="tfoot-fixed fw-semibold fs-10">
                                <tr>
                                    <td colspan="3" class="table-light"></td>
                                    <td class="text-center table-light">{{ totals.samples }}</td>
                                    <td class="text-center table-light">{{ totals.analyses }}</td>
                                    <td class="text-center table-light">{{ formatMoney(totals.fees) }}</td>
                                    <td class="text-center table-danger">{{ formatMoney(totals.discount) }}</td>
                                    <td class="text-center table-success">{{ formatMoney(totals.gross) }}</td>
                                </tr>
                            </tfoot>
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
    props: ['years','selected','laboratories','discounts'],
    data(){
        return {
            selectedRow: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            years: this.years,
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            laboratory: null,
            discount: null,
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
         'discount'(){
            this.fetch();
        }
    },
    computed: {
        totals() {

            const clean = (value) => {
                if (!value) return 0;

                return Number(
                    value
                        .toString()
                        .replace(/₱/g, '')
                        .replace(/,/g, '')
                        .trim()
                ) || 0;
            };

            return this.list.reduce((acc, item) => {

                acc.samples += clean(item.samples);
                acc.analyses += clean(item.analyses);
                acc.fees += clean(item.fees);
                acc.discount += clean(item.discount);
                acc.gross += clean(item.gross);

                return acc;

            }, {
                samples: 0,
                analyses: 0,
                fees: 0,
                calibration: 0,
                discount: 0,
                gross: 0
            });
        }
    },
    methods: {
        fetch(){
            axios.get('/insights/customers',{
                params : {
                    month: this.month,
                    year: this.year,
                    discount: this.discount,
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
            window.open('/accomplishments?option=perdiscount&month='+this.month+'&year='+this.year+'&laboratory='+this.laboratory);
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