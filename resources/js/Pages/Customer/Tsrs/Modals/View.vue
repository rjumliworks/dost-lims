<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 750px;" hide-footer title="TSR Details" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
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
                            <p class="text-muted fs-11 mb-0">Total :</p>
                            <h5 class="fs-12 mb-0">{{selected.payment?.total}}</h5>
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
                            <p class="text-muted fs-11 mb-0">Due Date :</p>
                            <h5 class="fs-12 mb-0">{{selected.due_at}}</h5>
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
                            <p class="text-muted fs-11 mb-0">Request Date :</p>
                            <h5 class="fs-12 mb-0">{{selected.created_at}}</h5>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-md-12 mt-3 mb-n4">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex" style="margin-bottom: -18px;">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-price-tag-2-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">List of Samples</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Overview of services availed, including paid and outstanding charges.</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card rounded-bottom">
                            <table class="table align-middle table-centered mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th class="text-center" style="width: 7%">#</th>
                                        <th>Sample</th>
                                        <th class="text-center" style="width: 30%;">Report no.</th>
                                        <th style="width: 25%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in selected.samples" v-bind:key="index">
                                        <td class="text-center fs-12">1</td>
                                        <td class="text-start">
                                            <span class="fw-semibold text-primary fs-12">{{list.code}}</span>
                                            <p class="text-muted fs-12 mb-0" style="margin-top: -3px;">{{list.samplename?.name ?? '-'}}</p>
                                        </td>
                                        <td class="text-center">{{ list.report?.code ?? '-' }}</td>
                                        <td class="text-end">
                                             <button type="button" @click="openPdf(list.report.attachment)" class="btn btn-primary btn-sm">Donwload</button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
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
            attachment: null,
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
        openPdf(attachment) {
            this.attachment = JSON.parse(attachment);
            window.open(`/storage/uploads/testreports/${this.attachment.name}`, '_blank');
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>