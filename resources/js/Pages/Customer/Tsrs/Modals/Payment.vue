<template>
<b-modal v-model="showModal" style="--vz-modal-width: 600px;" hide-footer header-class="p-3 bg-light" title="Pay with QRPH" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
    
    <BRow class="g-3 p-2 mb-3">
        <div class="bg-white p-6 rounded w-[400px]">
           
            <p class="text-center text-sm fs-14 fw-semibold text-primary mt-4 mb-3">
                <img src="/images/payments/qr-code.png" style="height:32px;" />
                <span class="text-primary fs-16">SCAN TO PAY</span>
            </p>

            <p class="text-center fs-12 text-muted">
                Powered by QRPH (GCash, Maya, and other banks supported)
            </p>
            <div class="d-flex justify-content-center" style="margin-top: -13px;">
                <img src="/images/payments/gcash.png" style="height:20px;" />
                <img src="/images/payments/maya.png" style="height:16px; margin-top: 2px;" />
                <img src="/images/payments/qrph.png" style="height:16px; margin-top: 2px;" />
            </div>

            <div class="d-flex justify-content-center mt-3">
                <img class="img-thumbnail" alt="200x200" width="300" v-if="qrUrl" :src="qrUrl">
            </div>

            <div class="text-center mt-3">
                <span :class="(countdown == 'Expired') ? 'text-danger' : 'text-info'" class="fw-semibold fs-16">
                    Expires in: {{ countdown }}
                </span>
            </div>

        </div>
    </BRow>
</b-modal>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, Textarea },
    data(){
        return {
            amount: null,
            showModal: false,
            qrUrl: null,
            countdown: '',
            expiresAt: null,
            timerInterval: null,
            paymentStatus: null,
            loading: false,
            interval: null,
            qr: null
        }
    },
    methods: { 
        async show(data) {
           
            this.showModal = true;
            this.loading = true
            this.qrUrl = null

            if(data.online){
                try {
                    const response = await axios.get(
                        `/payments/${data.online.payment_intent_id}/qr`
                    )
                    this.paymentStatus = response.data.status;
                    this.qrUrl = response.data.qr;
                    this.expiresAt = response.data.expires_at;
                    this.startCountdown();
                     this.startPolling();
                    
                    // this.qrUrl = res.next_action?.code?.image_url ?? null;
                    // this.expiresAt = res.next_action?.code?.expires_at;
                   
                }catch(error) {
                    console.error(error)
                }

            }else{
                try {
                    const response = await axios.post('/payments/qrph',{
                            amount: data.amount,
                            code: data.code,
                        }
                    )
                    const res = response.data;
                    this.paymentIntentId = res.payment_intent_id;
                    this.qrUrl = res.next_action?.code?.image_url ?? null;
                    this.expiresAt = res.next_action?.code?.expires_at;
                    this.startCountdown();
                    this.startPolling();

                }catch (error) {
                    console.error(error)
                    alert('Unable to create payment.')
                    this.closeModal()
                } finally {
                    this.loading = false
                }
            }
        },
        startPolling() {
            this.interval = setInterval(async () => {
                try {
                    const response = await axios.get(
                        `/payments/${this.paymentIntentId}/status`
                    )
                    this.paymentStatus = response.data.status;

                    if (this.paymentStatus === 'succeeded'){
                        clearInterval(this.interval)
                        alert('Payment Successful')
                        this.closeModal()
                        window.location.reload()
                    }

                    if(this.paymentStatus === 'failed'){
                        clearInterval(this.interval)
                        alert('Payment Failed')
                    }
                }catch(error) {
                    console.error(error)
                }

            }, 3000)
        },
        startCountdown() {
            clearInterval(this.timerInterval)

            this.timerInterval = setInterval(() => {
                const now = new Date().getTime()
                const expiry = new Date(this.expiresAt).getTime()
                const distance = expiry - now

                /*
                |--------------------------------------------------------------------------
                | EXPIRED
                |--------------------------------------------------------------------------
                */

                if (distance <= 0) {

                    clearInterval(this.timerInterval)

                    this.countdown = 'Expired'

                    return
                }

                /*
                |--------------------------------------------------------------------------
                | TIME COMPUTATION
                |--------------------------------------------------------------------------
                */

                const minutes = Math.floor(
                    (distance % (1000 * 60 * 60))
                    / (1000 * 60)
                )

                const seconds = Math.floor(
                    (distance % (1000 * 60))
                    / 1000
                )

                this.countdown =
                    `${minutes}:${seconds
                        .toString()
                        .padStart(2, '0')}`

            }, 1000)
        },
        beforeUnmount() {
            clearInterval(this.interval)
        },
        hide(){
            clearInterval(this.interval);
            clearInterval(this.timerInterval);
            this.showModal = false;
        }
    }
}
</script>
