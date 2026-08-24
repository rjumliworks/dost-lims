<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 780px;" header-class="p-3 bg-light" title="Stock Information" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop hide-footer>
        <div class="d-flex gap-3" v-if="selected">
            <div class="flex-shrink-0 text-center">
                <div class="border rounded p-3 bg-white">
                    <img :src="selected.qr" alt="QR Code" width="180" height="180"/>
                    <h5 class="fs-14 fw-semibold text-uppercase text-primary mt-3 mb-0">{{ selected.name }}</h5>
                    <p class="fs-13 text-muted mb-0">{{ selected.code }}</p>
                </div>
                <b-button @click="printLabel()" variant="primary" size="sm" class="w-100 mt-2">
                    <i class="ri-printer-fill align-bottom me-1"></i> Print
                </b-button>
            </div>
            <div class="flex-grow-1">
                <div class="table-responsive">
                    <table class="table table-borderless table-sm mb-0 fs-13">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width:40%;">Brand</td>
                                <td class="fw-semibold">{{ selected.brand }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">S.N. / B.N.</td>
                                <td class="fw-semibold">{{ selected.number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Supplier</td>
                                <td class="fw-semibold">{{ selected.supplier }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Content</td>
                                <td class="fw-semibold">{{ selected.unit }} {{ selected.type }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">On Hand</td>
                                <td class="fw-semibold">{{ selected.onhand }} / {{ selected.quantity }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Price</td>
                                <td class="fw-semibold">{{ selected.price }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Bought Date</td>
                                <td class="fw-semibold">{{ selected.bought_at }}</td>
                            </tr>
                            <tr v-if="selected.expired_at">
                                <td class="text-muted">Expiry Date</td>
                                <td class="fw-semibold">{{ selected.expired_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            selected: null,
        }
    },
    methods: {
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        printLabel(){
            window.open('/inventory?option=print-label&id='+this.selected.id);
        }
    }
}
</script>
