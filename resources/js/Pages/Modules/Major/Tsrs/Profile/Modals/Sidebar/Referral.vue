<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 600px;" title="Referral Information" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
       <div class="row g-2">
            <div class="col-md-12">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-government-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Agency :</p>
                            <h5 class="fs-12 mb-0">{{(selected.agency) ? selected.agency.member.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-map-pin-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Province :</p>
                            <h5 class="fs-12 mb-0">{{(selected.province) ? selected.province.name : 'Not Available'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Date :</p>
                            <h5 class="fs-12 mb-0">{{selected.created_at}}</h5>
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
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                agency: { member: {}}, province: {}
            },
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(data){
            this.form.option = data;
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>