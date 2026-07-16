<template>
<Head title="TSRs"/>
<PageHeader title="TSR Management" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-folder-2-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">My Requests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Keep track of your personal and shared folders, organized for quick access and easy management.</p>
                        </div>
                        <div class="flex-shrink-0" style="width: 45%;">
                           
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Folder" class="form-control" style="width: 20%;">
                                <!-- <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span> -->
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <!-- <i class="ri-add-circle-fill align-bottom me-1"></i> New Quotation -->
                                     <i class="bx bx-refresh search-icon"></i>
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
              
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="margin-top: -17px; height: calc(100vh - 465px); overflow: auto;">
                        <table class="table align-middle table-centered table-striped mb-0">
                             <thead class="table-light thead-fixed">
                                <tr class="fs-10">
                                    <th style="width: 4%;"></th>
                                    <th>Code</th>
                                    <th style="width: 15%;" class="text-center">Due At</th>
                                    <th style="width: 15%;" class="text-center">Request At</th>
                                    <th style="width: 15%;" class="text-center">Total</th>
                                    <th style="width: 16%;" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                                    <td class="text-center">{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td>{{list.code}}</td>
                                    <td class="text-center">{{list.due_at}}</td>
                                    <td class="text-center">{{list.created_at}}</td>
                                    <td class="text-center">{{list.payment.total}}</td>
                                    <td class="text-center" v-if="list.completed_report_count == list.total_report_count">
                                        <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-center" v-else>{{ list.completed_report_count }} of {{ list.total_report_count }}</td>
                                    <!-- <td class="text-center"><span :class="'badge '+list.status.color">{{list.status.name}}</span></td> -->
                                    <td class="text-end">
                                        <button v-if="list.status.name == 'For Payment'" type="button" @click="payEgov(list,index)" class="btn btn-danger btn-sm w-md">Pay with EGOV</button>
                                        <button v-if="list.status.name == 'For Payment'" type="button" @click="pay(list,index)" class="btn btn-danger btn-sm w-md">Pay with QRPH</button>
                                        <!-- <button v-if="list.status.name == 'For Payment'" type="button" @click="payNow(list)" class="btn btn-dark btn-sm w-md">Pay now</button> -->
                                        <button v-else type="button" @click="openView(list)" class="btn btn-soft-dark btn-sm w-md">View TSR</button>
                                          <b-button @click="openPrint(list.reference)" variant="info" class="ms-1" v-b-tooltip.hover title="Print" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No records found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                </div>
            </div>
        </div>
    </BRow>
    <View ref="view"/>
    <Payment @completed="updateTsr" ref="payment"/>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Payment from './Modals/Payment.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, View, Payment },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null
            },
            index: null,
            selectedRow: null,
        }
    },
    created(){
        this.fetch();
    },
    methods: { 
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/tsrs';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    count: 10, 
                    option: 'list'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
        openView(data){
            console.log(data);
              const response = axios.get(
                        `/payments/${data.onlinepayment.payment_intent_id}`
                        
                    );
                    console.log(response);
            this.$refs.view.show(data);
        },
        updateTsr(data){
            console.log(data);
            this.lists[this.index] = data;
        },
        openPrint(reference){
            window.open('/tsrs?option=print&id='+reference);
        },
        payEgov(list,index){
            // this.form.post('/egovpay/pay',{
            //     preserveScroll: true,
            //     onSuccess: (response) => {
            //         window.location.href = page.props.url;
            //     },
            // });

            const rawAmount = list.payment.total;
            const cleanAmount = Number(
                rawAmount.toString()
                    .replace(/₱/g, '')
                    .replace(/,/g, '')
            );
            axios.post('/egovpay/pay', {
                    amount: cleanAmount,
                })
                .then((response) => {
                    window.location.href = response.data.url;
                })
                .catch((error) => {
                    console.error(error);
                });
                 this.index = index;
        },
        pay(list,index){
            const rawAmount = list.payment.total;
            const cleanAmount = Number(
                rawAmount.toString()
                    .replace(/₱/g, '')
                    .replace(/,/g, '')
            );

            this.$refs.payment.show({
                amount: cleanAmount,
                code: list.reference,
                online: list.onlinepayment
            });
            this.index = index;
        },
        async payNow(list) {
            const rawAmount = list.payment.total;

            const cleanAmount = Number(
                rawAmount.toString().replace(/₱/g, '').replace(/,/g, '')
            );

            const res = await axios.post('/checkout', {
                code: list.reference,
                amount: cleanAmount
            });

            window.location.href = res.data.checkout_url;
        }

    }
}
</script>

<!-- //     this.form.amount = cleanAmount;

        //     // this.$inertia.post('/checkout', {
        //     //     amount: cleanAmount
        //     // });
        //      this.form.post('/checkout',{
        //         preserveScroll: true,
        //         onSuccess: (page) => {
        //     // IMPORTANT: get response from page props
        //     const checkoutUrl = page.props.checkout_url;

        //     if (checkoutUrl) {
        //         window.location.href = checkoutUrl;
        //     }
        // },
        //     }); -->