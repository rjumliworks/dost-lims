<template>
  <b-modal
    v-if="selected"
    v-model="showModal"
    style="--vz-modal-width: 700px;"
    header-class="p-3 bg-light"
    title="View Report Number"
    class="v-modal-custom"
    modal-class="zoomIn"
    centered
    no-close-on-backdrop
  >
    <!-- ...content omitted for brevity... -->
<div class="row mb-3">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ selected.code }}</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <div v-if="selected.lists.length == 0">Sample Code : 
                                    <span v-if="selected.sample_code" class="fw-medium"> {{ selected.sample_code}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div v-if="selected.lists.length == 0" class="vr" style="width: 1px;"></div>
                                <div>TSR Code : 
                                    <span v-if="selected.tsr_code" class="fw-medium">{{selected.tsr_code}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Analyst. : 
                                    <span v-if="selected.user" class="fw-medium">{{selected.user}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted" v-if="selected.lists.length > 0"/>
        <div class="row" v-if="selected.lists.length > 0" style="max-height: 130px; overflow: auto;">
            <div class="col-md-3" v-for="(column, index) in columns" :key="index">
                <ul class="list-unstyled">
                    <li v-for="(item, idx) in column" :key="idx" class="py-1 fs-12">
                        <i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> {{ item.sample.code }}
                    </li>
                </ul>
            </div>
        </div>
        <hr class="text-muted mt-0"/>
        <div class="row mt-2">
            <div class="col-sm-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Report Date :</p>
                            <h5 class="mb-0 fs-12">{{selected.created_at}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Released Date :</p>
                            <h5 class="mb-0 fs-12">-</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted"/> 
        <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show mb-n2" role="alert">
            <i class="ri-qr-code-fill label-icon"></i><strong>QR Code</strong> - <span style="cursor: pointer;" @click="printQr()">Click here to print</span>
        </div>
       
    <template v-slot:footer>
      <b-button @click="hide" variant="light" block>Close</b-button>
      <b-button @click="openResult" variant="primary" block>Preview</b-button>
    </template>
  </b-modal>
   <Result ref="result"/>
</template>

<script>
import simplebar from "simplebar-vue";
import Result from './Result.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';

export default {
  components: { InputLabel, TextInput, simplebar, Result },
  data() {
    return {
      currentUrl: window.location.origin,
      showModal: false,
      selected: null,
      parameters: [{ name: null, result: null }],
      scale: 4.0,
      signaturePos: { x: 0, y: 0 },
      pdfUrl: null,
      pdfDoc: null,
        currentPage: 1,
        totalPages: 0,
    };
  },
  computed: {
    columns() {
      const chunkSize = Math.ceil(this.selected.lists.length / 4);
      const result = [];
      for (let i = 0; i < this.selected.lists.length; i += chunkSize) {
        result.push(this.selected.lists.slice(i, i + chunkSize));
      }
      return result;
    }
  },
  methods: {
    show(data) {
        this.signaturePos.x = 0;
        this.signaturePos.y = 0;
      this.selected = data;
      this.parameters = this.selected.analyses.map(analysis => ({
        name: analysis.testservice.testname.name,
        result: null
      }));
      this.showModal = true;
      this.pdfUrl = `/storage/uploads/testreports/${this.selected.attachment.name}`;
      this.$nextTick(() => {
        this.renderPdf();
        this.makeDraggable();
      });
    },
     openResult(){
            this.$refs.result.show(this.parameters,this.selected.sample_id);
        },
         printQr(id){
            window.open('/testreports?option=qrcode&id='+this.selected.qr);
        },
    hide() {
      this.showModal = false;
    },
  }
};
</script>
