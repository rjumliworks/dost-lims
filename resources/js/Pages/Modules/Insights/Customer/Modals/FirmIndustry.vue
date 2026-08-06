<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1200px;" hide-footer header-class="p-3 bg-light" title="View Firms by Industry" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-building-2-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">{{title}}</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Shows the leading players in each firm</p>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-bottom shadow-none">
                        <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                            <b-col lg>
                                <div class="input-group mb-1 d-flex flex-nowrap">
                                    <span class="input-group-text">
                                        <i class="ri-search-line search-icon"></i>
                                    </span>
                                    <Multiselect
                                        class="white no-radius"
                                        :options="years"
                                        v-model="year"
                                        :can-clear="false" :can-deselect="false"
                                        placeholder="Year"
                                    />
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card" style="margin-top: -39px; margin-bottom: -33px; height: calc(100vh - 465px); overflow: auto;">
                            <table class="table align-middle table-centered table-nowrap mb-3">
                                <thead class="text-muted table-light fs-11">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">#</th>
                                        <th scope="col">Name</th>
                                        <th class="text-center" style="width: 10%;">Total</th>
                                        <th class="text-end" style="width: 16%;">Gross Sales</th>
                                        <th class="text-center" style="width: 10%;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in listsWithPercentage" v-bind:key="index">
                                        <td class="text-center">{{ index + 1 }}.</td>
                                        <td>{{ list.name }}</td>
                                        <td class="text-center">{{ list.count }}</td>
                                        <td class="text-end">{{ formatMoney(list.gross_sales) }}</td>
                                        <td class="text-center">{{ list.percentage }}%</td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="listsWithPercentage.length" class="table-light fw-bold tfoot-fixed">
                                    <tr>
                                        <td colspan="2" class="text-end">Total</td>
                                        <td class="text-center">{{ totalCount }}</td>
                                        <td class="text-end">{{ formatMoney(totalGrossSales) }}</td>
                                        <td class="text-center">{{ totalPercentage }}%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </BRow>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
export default {
    props: ['dropdowns','current_year','years'],
    components: { Multiselect },
    data() {
        return {
            title: null,
            lists: [],
            year: this.current_year,
            showModal: false
        }
    },
    computed: {
        listsWithPercentage(){
            const lists = this.lists || [];
            const grandTotal = lists.reduce((sum, list) => sum + Number(list.gross_sales || 0), 0);

            if (!grandTotal) {
                return lists.map(list => ({ ...list, percentage: '0.0' }));
            }

            // Largest remainder method so displayed percentages always sum to exactly 100.
            const shares = lists.map(list => {
                const exact = (Number(list.gross_sales || 0) / grandTotal) * 1000;
                return { floor: Math.floor(exact), remainder: exact - Math.floor(exact) };
            });

            let allocated = shares.reduce((sum, s) => sum + s.floor, 0);
            let remaining = 1000 - allocated;

            const order = shares
                .map((s, index) => ({ index, remainder: s.remainder }))
                .sort((a, b) => b.remainder - a.remainder);

            for (let i = 0; i < remaining; i++) {
                shares[order[i].index].floor += 1;
            }

            return lists.map((list, index) => ({
                ...list,
                percentage: (shares[index].floor / 10).toFixed(1),
            }));
        },
        totalCount(){
            return this.listsWithPercentage.reduce((sum, list) => sum + Number(list.count || 0), 0);
        },
        totalGrossSales(){
            return this.listsWithPercentage.reduce((sum, list) => sum + Number(list.gross_sales || 0), 0);
        },
        totalPercentage(){
            return this.listsWithPercentage.reduce((sum, list) => sum + Number(list.percentage || 0), 0).toFixed(1);
        },
    },
    watch: {
        "year"(){
            this.fetch();
        }
    },
    methods: {
        show(title){
            this.title = title;
            this.year = this.current_year;
            this.fetch();
            this.showModal = true;
        },
        fetch(){
            axios.get('/insights/customers', {
                params: {
                    option: 'firms_industry',
                    year: this.year
                }
            })
            .then(response => {
                this.lists = response.data;
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
