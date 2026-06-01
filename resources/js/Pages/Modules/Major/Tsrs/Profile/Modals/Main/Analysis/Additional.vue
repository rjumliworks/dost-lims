<template>
  <b-modal
    v-model="showModal"
    header-class="p-3 bg-light"
    title="Add additional fee"
    class="v-modal-custom"
    modal-class="zoomIn"
    centered
    no-close-on-backdrop
  >
    <div class="mb-3 fs-11" v-for="(item, index) in services" :key="index">
      <b-form-checkbox
        v-model="item.selected"
        @change="onServiceToggle(item)"
        :value="true"
        :unchecked-value="false"
        switch
      >
        {{ item.name }} -  {{ getDisplayFee(item) }}
      </b-form-checkbox>

      <b-form-input
        type="number"
        class="mt-2"
        v-model="item.quantity"
        :disabled="!item.selected"
        min="1"
        placeholder="Enter quantity"
      />
    </div>

    <template v-slot:footer>
      <b-button @click="hide()" variant="light" block>Close</b-button>
      <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
    </template>
  </b-modal>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            form: useForm({
                id: null,
                tsr_id: null,
                services: [],
                option: 'fee'
            }),
            services: [],
            showModal: false
        }
    },
    computed: {
        total() {
            const total = this.selected.fee.replace(/₱|,/g, '') * this.form.quantity;
            this.form.total = total;
            return this.formatMoney(total);
        }
    },
    methods: { 
        getDisplayFee(item) {
            if (Number(item.is_child) === 1) {
                return this.formatMoney(this.parseMoney(item.fee));
            }

            const childTotal = this.services
                .filter(s => Number(s.is_child) === 1 && s.selected)
                .reduce((sum, child) => {
                    return sum + (this.parseMoney(child.fee) * Number(child.quantity));
                }, 0);
            
            item.fee = this.parseMoney(item.original_fee || item.fee) + childTotal;
             return this.formatMoney(item.fee);
        },
        parseMoney(value) {
            return Number(String(value).replace(/₱|,/g, '')) || 0;
        },
        show(data,id,tsr){
            this.form.tsr_id = tsr;
            this.form.id = id;
            this.services = data
            .sort((a, b) => Number(a.is_child) - Number(b.is_child))
            .map(service => ({
                ...service,
                selected: false,
                original_fee: service.fee,
                fee: service.fee,
                quantity: 1
            }));

            this.showModal = true;
        },
         onServiceToggle(item) {
            if (!item.selected) item.quantity = 1;
        },
        submit(){
            this.form.services = this.services
                .filter(s => s.selected)
                .map(s => ({
                    id: s.id,
                    is_child: s.is_child,
                    quantity: s.quantity,
                    fee: s.fee
                }));

            if (this.form.services.length === 0) {
                this.$bvToast.toast('Please select at least one service.', {
                variant: 'warning',
                solid: true
                });
                return;
            }

            this.form.post('/analyses',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.hide();
                },
            });
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