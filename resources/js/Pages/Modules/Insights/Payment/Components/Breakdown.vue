<template>
    <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i :class="icon+' text-primary fs-24'"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">{{title}}</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">{{description}}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="mt-1">
                        <button @click="openView()" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View All">
                            <i class="ri-eye-fill align-bottom"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-white">
            <div class="table-responsive table-card">
                <simplebar data-simplebar style="height: 270px;">
                    <table class="table align-middle table-centered table-nowrap mb-3">
                        <thead class="bg-white fs-11 thead-fixed">
                            <tr>
                                <th style="width: 4%;">#</th>
                                <th scope="col">Name</th>
                                <th class="text-center" style="width: 10%;">Count</th>
                                <th class="text-end" style="width: 20%;">Amount</th>
                                <th class="text-center" style="width: 10%;">%</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light-subtle fs-12">
                            <tr v-for="(list,index) in listsWithPercentage" v-bind:key="index">
                                <td>{{index + 1}}</td>
                                <td class="text-truncate name-cell">{{list.name}}</td>
                                <td class="text-center">{{list.count}}</td>
                                <td class="text-end">{{formatMoney(list.amount)}}</td>
                                <td class="text-center">{{list.percentage}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </simplebar>
            </div>
            <div class="d-flex justify-content-end fs-12 fw-bold mt-1 pe-1" v-if="listsWithPercentage.length">
                <span>Total: {{totalPercentage}}%</span>
            </div>
        </div>
    </div>
    <BreakdownModal :current_year="current_year" :years="years" ref="modal"/>
</template>
<script>
import simplebar from "simplebar-vue";
import BreakdownModal from '../Modals/Breakdown.vue';
export default {
    props: ['lists', 'title', 'description', 'icon', 'option', 'current_year', 'years'],
    components: { simplebar, BreakdownModal },
    computed: {
        listsWithPercentage(){
            const lists = this.lists || [];
            const grandTotal = lists.reduce((sum, list) => sum + Number(list.amount || 0), 0);

            if (!grandTotal) {
                return lists.map(list => ({ ...list, percentage: '0.0' }));
            }

            // Largest remainder method so displayed percentages always sum to exactly 100.
            const shares = lists.map(list => {
                const exact = (Number(list.amount || 0) / grandTotal) * 1000;
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
        totalPercentage(){
            return this.listsWithPercentage.reduce((sum, list) => sum + Number(list.percentage || 0), 0).toFixed(1);
        },
    },
    methods: {
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        openView(){
            this.$refs.modal.show(this.option, this.title, this.description);
        }
    }
}
</script>
