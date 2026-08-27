<template>
    <div>
        <div class="row g-2 mb-3">
            <div class="col-6 col-md-3">
                <div class="card bg-light-subtle shadow-none border mb-0">
                    <div class="card-body p-2 text-center">
                        <p class="text-muted mb-0 fs-11">Tests Performed</p>
                        <h5 class="mb-0 fs-16">{{ summary.tests_performed }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-light-subtle shadow-none border mb-0">
                    <div class="card-body p-2 text-center">
                        <p class="text-muted mb-0 fs-11">Samples Handled</p>
                        <h5 class="mb-0 fs-16">{{ summary.samples_handled }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-light-subtle shadow-none border mb-0">
                    <div class="card-body p-2 text-center">
                        <p class="text-muted mb-0 fs-11">Avg. Turnaround</p>
                        <h5 class="mb-0 fs-16">{{ (summary.avg_turnaround_days !== null) ? summary.avg_turnaround_days + ' day(s)' : '-' }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-light-subtle shadow-none border mb-0">
                    <div class="card-body p-2 text-center">
                        <p class="text-muted mb-0 fs-11">Total Test Cost</p>
                        <h5 class="mb-0 fs-16">{{ formatMoney(summary.total_cost) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text"><i class="ri-filter-3-line"></i></span>
            <Multiselect v-if="laboratories && laboratories.length > 1" class="white" style="flex: 1 1 0%;" :options="laboratories" v-model="laboratory" label="name" :searchable="true" placeholder="All Laboratories" />
            <Multiselect class="white" style="flex: 1 1 0%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by Month" />
            <input type="text" placeholder="Year" v-model="year" class="form-control" style="flex: 0 0 110px;">
            <button @click="openExcel()" class="btn btn-soft-success" type="button" title="Export to Excel">
                <i class="ri-file-excel-fill align-bottom"></i>
            </button>
            <button @click="openPrint()" class="btn btn-soft-info" type="button" title="Export to PDF">
                <i class="ri-printer-fill align-bottom"></i>
            </button>
        </div>

        <div class="table-responsive">
            <simplebar data-simplebar style="max-height: 400px;">
                <table class="table align-middle table-bordered table-centered table-nowrap mb-0">
                    <thead class="bg-dark-subtle fs-11 thead-fixed">
                        <tr>
                            <th class="text-center" style="width: 22%">Month</th>
                            <th class="text-center" style="width: 22%">No. of Test Performed</th>
                            <th class="text-center" style="width: 20%">Samples Handled</th>
                            <th class="text-center" style="width: 18%">Avg. Turnaround</th>
                            <th class="text-center" style="width: 18%">Total Test Cost</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light-subtle fs-12">
                        <tr class="fs-11" v-for="(count, month) in monthly" :key="month">
                            <td class="text-center">{{ month }}</td>
                            <td class="text-center">{{ count.tests_performed }}</td>
                            <td class="text-center">{{ count.samples_handled }}</td>
                            <td class="text-center">{{ (count.avg_turnaround_days !== null) ? count.avg_turnaround_days + ' day(s)' : '-' }}</td>
                            <td class="text-center">{{ formatMoney(count.total_cost) }}</td>
                        </tr>
                        <tr class="fw-semibold fs-11 bg-light text-dark">
                            <td class="text-center">Total</td>
                            <td class="text-center">{{ summary.tests_performed }}</td>
                            <td class="text-center">{{ summary.samples_handled }}</td>
                            <td class="text-center">{{ (summary.avg_turnaround_days !== null) ? summary.avg_turnaround_days + ' day(s)' : '-' }}</td>
                            <td class="text-center">{{ formatMoney(summary.total_cost) }}</td>
                        </tr>
                    </tbody>
                </table>
            </simplebar>
        </div>
    </div>
</template>
<script>
import simplebar from "simplebar-vue";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, simplebar },
    props: ['laboratories'],
    data(){
        const months = [
            'January - June', 'July - December'
        ];
        const currentMonthIndex = new Date().getMonth();
        const month = currentMonthIndex <= 5 ? months[0] : months[1];
        return {
            monthly: {},
            summary: {
                tests_performed: 0,
                total_cost: 0,
                samples_handled: 0,
                avg_turnaround_days: null
            },
            months: months,
            month: month,
            year: new Date().getFullYear(),
            laboratory: null
        }
    },
    watch: {
        year() {
            this.fetch();
        },
        month() {
            this.fetch();
        },
        laboratory() {
            this.fetch();
        }
    },
    created(){
        this.fetch();
    },
    methods : {
        fetch(page_url){
            page_url = page_url || '/fetch';
            axios.get(page_url,{
                params : {
                    year: this.year,
                    month: this.month,
                    laboratory: this.laboratory,
                    option: 'performance'
                }
            })
            .then(response => {
                if(response){
                    this.monthly = response.data.monthly;
                    this.summary = response.data.summary;
                }
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        exportUrl(option){
            const params = new URLSearchParams({
                year: this.year,
                month: this.month,
                laboratory: this.laboratory || '',
                option: option
            });
            return '/fetch?'+params.toString();
        },
        openExcel(){
            window.open(this.exportUrl('performance-excel'));
        },
        openPrint(){
            window.open(this.exportUrl('performance-print'));
        }
    }
}
</script>
