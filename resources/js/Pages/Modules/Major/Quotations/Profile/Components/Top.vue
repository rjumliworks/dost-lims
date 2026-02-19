<template>
    <b-col lg="12">
        <b-card no-body>
            <div class="bg-warning-subtle">
                <b-card-body class="pb-0 px-4">
                    <b-row class="mb-3">
                        <b-col md>
                            <b-row class="align-items-center g-3">
                                <b-col md>
                                    <div>
                                        <h4 class="fw-semibold text-primary">{{(selected.code) ? selected.code+' - ' : ''}} <span class="fs-15">{{selected.customer.name}}</span></h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div><i class="ri-map-pin-2-fill align-bottom me-1"></i>{{selected.customer.address.name}}</div>
                                            <div class="vr"></div>
                                            <div><i class="ri-account-circle-fill align-bottom me-1"></i>{{selected.conforme}}</div>
                                            <div class="vr"></div>
                                            <div><i class="ri-phone-fill align-bottom me-1"></i>{{selected.conforme_no}}</div>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="auto">
                            <div class="hstack gap-4 flex-wrap mt-2">
                                <Link href="/quotations">
                                    <div class="text-muted" @click="hide()">  
                                        <i class="ri-close-circle-fill fs-16"></i> Close
                                    </div>
                                </Link>
                                <div class="text-muted" v-if="selected.status.name == 'Pending'" @click="openCancel(selected.reference)" style="cursor: pointer;">  
                                    <i class="ri-delete-bin-fill fs-16"></i> Cancel
                                </div>
                                <div class="text-muted" v-if="selected.status.name === 'Pending'" @click="openEdit(selected,index)" style="cursor: pointer;">  
                                    <i class="ri-edit-box-fill fs-16"></i> Update
                                </div>
                                <div class="text-muted" @click="makeCopy(selected)" style="cursor: pointer;">  
                                    <i class="ri-edit-box-fill fs-16"></i> Make a Copy
                                </div>
                                <div class="text-muted" @click="openSubmit(selected)" style="cursor: pointer;">  
                                    <i class="ri-file-list-fill fs-16"></i> Convert to TSR
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div v-if="selected.status.name === 'Pending'">  
                                    <b-button @click="openSave(selected.reference)" variant="primary" block :disabled="!allSamplesHaveAnalyses"><i class="ri-save-fill me-1"></i> Save</b-button>
                                </div>
                                 <div v-if="selected.status.name !== 'Pending'" @click="openPrint(selected.reference)">  
                                    <b-button variant="primary" block><i class="ri-printer-fill me-1"></i> Print</b-button>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                </b-card-body>
            </div>
        </b-card>
    </b-col>
    <Copy ref="copy"/>
    <Save ref="save"/>
    <Cancel ref="cancel"/>
    <Submit ref="submit"/>
    <Update :dropdowns="dropdowns" ref="update"/>
    <Edit :dropdowns="dropdowns" ref="edit"/>
</template>
<script>
import Copy from '../Modals/Top/Copy.vue';
import Edit from '../Modals/Top/Edit.vue';
import Save from '../Modals/Top/Save.vue';
import Cancel from '../Modals/Top/Cancel.vue';
import Update from '../Modals/Top/Update.vue';
import Submit from '../Modals/Top/Submit.vue';
export default {
    components: { Save, Edit, Cancel, Update, Copy, Submit },
    props:['selected','analyses','dropdowns'],
    computed: {
        allSamplesHaveAnalyses() {
        if (!this.selected.samples || !this.selected.samples.length) return false;
        
        return this.selected.samples.every(sample => sample.analyses && sample.analyses.length > 0);
        }
    },
    methods: {
        openSave(id){
            this.$refs.save.show(id,this.selected.customer.industry,this.selected.facility);
        },
        openPrint(id){
            window.open('/quotations?option=print&id='+id);
        },
        openEdit(selected){
            this.$refs.edit.show(selected);
        },
        openCancel(data){
            this.$refs.cancel.show(data);
        },
        openUpdate(selected){
            this.$refs.update.show(selected);
        },
        openSubmit(data){
            this.$refs.submit.show(data,this.analyses);
        },
        makeCopy(data){
            this.$refs.copy.show(data);
        }
    }
}
</script>