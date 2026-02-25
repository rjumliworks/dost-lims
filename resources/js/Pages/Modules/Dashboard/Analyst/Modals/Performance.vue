<template>
    <b-modal v-model="showModal" title="Performance Summary"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="row">
            <div class="col-sm-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{$page.props.user.data.name}}</span></h6>
                            <div class="hstack gap-3 fs-12 mt-n2 flex-wrap">
                                <div><span class="fw-medium">{{ $page.props.roles[0] }}</span></div>
                                <!-- <div class="vr" style="width: 1px;"></div> -->
                                <!-- <div><span class="text-muted">Sample name</span> : 
                                    <span v-if="selected.name" class="fw-medium"> {{ selected.name }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div><span class="text-muted">Due Date</span>: 
                                    <span v-if="selected.tsr.due_at" class="fw-medium">{{selected.tsr.due_at}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="col-sm-12"><hr class="text-muted"/></div>

            <div class="col-sm-12 mb-n4">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="input-group mb-0">
                            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                            <Multiselect class="white" style="width: 50%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by Month" />
                            <input type="text"  placeholder="Search Sample Code/Name" v-model="year" class="form-control" style="width: 30%;">
                        </div>
                    </div>
                
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <simplebar data-simplebar style="max-height: 400px;">
                                <table class="table align-middle table-bordered table-centered table-nowrap">
                                    <thead class="bg-dark-subtle fs-11 thead-fixed">
                                        <tr>
                                            <th class="text-center" style="width: 30%">Month</th>
                                            <th class="text-center" style="width: 30%">No. of Test Performed</th>
                                            <th class="text-center" style="width: 40%">Total Test Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light-subtle fs-12">
                                        <tr class="fs-11" v-for="(count, month) in selected" :key="month">
                                            <td class="text-center">{{ month }}</td>
                                            <td class="text-center">{{ count.tests_performed }}</td>
                                            <td class="text-center">{{ formatMoney(count.total_cost) }}</td>
                                        </tr>
                                        <tr class="fw-semibold fs-11 bg-light text-dark">
                                            <td class="text-center">Total</td>
                                            <td class="text-center">{{ totals.tests }}</td>
                                            <td class="text-center">{{ formatMoney(totals.cost) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
import simplebar from "simplebar-vue";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, simplebar },
    data(){
        const months = [
            'January - June', 'July - December'
        ];
        const currentMonthIndex = new Date().getMonth();
        const month = currentMonthIndex <= 5 ? months[0] : months[1];
        return {
            selected: {},
            months: months,
            month: month,
            year: new Date().getFullYear(),
            showModal: false
        }
    },
    computed: {
        totals() {
            let totalTests = 0;
            let totalCost = 0;

            Object.values(this.selected).forEach(item => {
                totalTests += item.tests_performed || 0;
                totalCost += parseFloat(item.total_cost) || 0;
            });

            return {
                tests: totalTests,
                cost: totalCost
            };
        }
    },
    watch: {
        year() {
            this.fetch();
        },
        month() {
            this.fetch();
        }
    },
    methods : {
        show() {
            this.fetch();
            this.showModal = true;
        },
        fetch(page_url){
            page_url = page_url || '/fetch';
            axios.get(page_url,{
                params : {
                    year: this.year,
                    month: this.month,
                    option: 'performance'
                }
            })
            .then(response => {
                if(response){
                    this.selected = response.data;       
                }
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>