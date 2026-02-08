<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 750px;" hide-footer title="Payment Details" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="selected.status.name == 'Pending'" class="alert alert-warning alert-dismissible alert-label-icon label-arrow fs-12" role="alert">
            <i class="ri-alert-line label-icon"></i><strong>Payment Not Settled</strong> - We noticed that your payment has not been settled
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-hashtag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">OR Number :</p>
                            <h5 class="fs-12 mb-0">{{(selected.or_number) ? selected.or_number : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-coupon-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Collection :</p>
                            <h5 class="fs-12 mb-0">{{(selected.collection) ? selected.collection.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Paid At :</p>
                            <h5 class="fs-12 mb-0">{{selected.paid_at}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-secure-payment-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Payment Method :</p>
                            <h5 class="fs-12 mb-0">{{(selected.type) ? selected.type.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-price-tag-2-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Discount :</p>
                            <h5 class="fs-12 mb-0">{{(selected.discounted) ? selected.discounted.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Status :</p>
                            <h5 class="fs-12 mb-0">{{(selected.status) ? selected.status.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
       </div>
        <div class="table-responsive fs-12">
            <div class="table-responsive">
                <table class="table text-center table-nowrap align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th scope="col" style="width: 50px;">#</th>
                            <th scope="col"></th>
                            <th scope="col" class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="products-list">
                        <tr>
                            <th scope="row">1</th>
                            <td class="text-start">
                                <span class="fw-medium">Laboratory Test Services</span>
                                <p class="text-muted fs-11 mb-0">Includes various laboratory analyses conducted as requested by the client</p>
                            </td>
                            <td class="text-end">{{formatMoney(total)}}</td>
                        </tr>
                        <tr v-for="(list,index) in services" v-bind:key="index">
                            <th scope="row">2</th>
                                <td class="text-start">
                                    <span class="fw-medium">{{list.service.name}}</span>
                                    <p class="text-muted fs-11 mb-0">{{list.service.description}}</p>
                                </td>
                            <td class="text-end">{{list.total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="border-top border-top-dashed mt-2 mb-3">
                <table class="table table-borderless table-nowrap align-middle table-sm mb-0 ms-auto" style="width:250px">
                    <tbody>
                        <tr>
                            <td>Sub Total</td>
                            <td class="text-end">{{selected.subtotal}}</td>
                        </tr>
                        <tr>
                            <td>Discount <small v-if="selected.discounted.name != 'Regular'" class="text-muted">({{selected.discounted.name}})</small></td>
                            <td class="text-end">{{selected.discount}}</td>
                        </tr>
                        
                        <tr class="border-top border-top-dashed fs-13">
                            <th scope="row">Total Amount</th>
                            <th class="text-end">{{selected.total}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                status:{}, collection:{}, type:{}, discounted:{}, service: {}
            },
            total: null,
            services: null,
            showModal: false
        }
    },
    methods: { 
        show(data,services,total){
            this.total = total;
            this.selected = data;
            this.services = services;
            this.showModal = true;
        },
        addfeeText(fees) {
            if (!fees || fees.length === 0) return '';
            const total = fees.reduce((sum, fee) => {
                const feeValue = Number(fee.total.toString().replace(/[₱,]/g, ''));
                return sum + feeValue;
            }, 0);
            const details = fees
                .map(fee => {
                    const feeVal = Number(fee.fee.toString().replace(/[₱,]/g, ''));
                    return `(${feeVal} x ${fee.quantity}) = ${Number(fee.total.toString().replace(/[₱,]/g, ''))}`;
                })
                .join(', '); 
                // ${details} → 
            return `(with ${this.formatMoney(total)} additional fees)`;
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