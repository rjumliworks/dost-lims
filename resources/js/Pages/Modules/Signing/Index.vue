<template>
    <Head title="Signing"/>
    <PageHeader title="Signing Document" pageTitle="List" />
    <BRow class="g-3">
        <b-col lg="3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-quill-pen-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Test Reports</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Awaiting Your Signature</p>
                        </div>
                    </div>
                </div>
                
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <div class="table-responsive mb-2" style="height: calc(100vh - 325px); overflow: auto;">
                        <table class="table table-nowrap table-striped align-middle">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th class="text-center" width="7%">#</th>
                                    <th>Report Number</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                <tr class="ribbon-box" v-for="(list,index) in reports" v-bind:key="index" @click="renderPdf(list,index)">
                                    <td class="text-center">{{  index + 1 }}.</td>
                                    <td>
                                        <h5 class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                        <p class="fs-12 text-muted mb-0">{{JSON.parse(list.attachment).name}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </b-col>
        <b-col lg="9">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle" v-if="selected">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-file-text-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1" v-if="selected">
                            <h5 class="mb-0 fs-14"><span class="text-body">{{ selected.code }}</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A comprehensive list of all TSRs (Test Service Requests) and Conformes, including their statuses and associated details.</p>
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body v-if="selected">
                    <div class="d-flex p-3">
                        <div class="flex-grow-1">
                            <!-- {{ selected }} -->
                            <h4>{{ selected.code }}</h4>
                            <div class="hstack gap-3 flex-wrap">
                                <div><a href="#" class="text-primary fw-semibold d-block">{{ selected.tsr.code }}</a></div>
                                <div class="vr"></div>
                                <div class="text-muted">Date Due : <span class="text-body fw-medium">{{ selected.tsr.due_at }}</span></div>
                                <div class="vr"></div>
                                <div class="text-muted">Date Created : <span class="text-body fw-medium">{{ selected.created_at }}</span></div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div  @click="placeSignature">  
                                <b-button variant="warning" block><i class="ri-ball-pen-fill me-1"></i>Sign</b-button>
                            </div>
                            <div v-if="showSave">  
                                            <b-button variant="primary" @click="savePdfWithSignature" block><i class="ri-save-fill me-1"></i> Save</b-button>
                                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom" 
                    :style="{
                        marginTop: selected ? '-23px' : '0px',
                        height: selected ? 'calc(100vh - 377px)' : 'calc(100vh - 292px)',
                        overflow: 'auto'
                    }" v-if="selected">
                    <div ref="pdfContainer" class="position-relative w-100">
                        <img
                            v-show="showSignature"
                            ref="signature"
                            :src="signature"
                            id="signature"
                            style="position: absolute; width: auto; height: 120px; cursor: move;"
                        />
                        <canvas
                            ref="pdfCanvas"
                            id="pdfcanvas"
                            class="border border-dashed rounded"
                            style="width: 100%; height: auto;"
                        ></canvas>

                        <div v-if="isRendering" class="loading-overlay-inside">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body rounded-bottom"  style="height: calc(100vh - 224px); overflow: auto;" v-if="!selected">
                     <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        
                        <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                        <p class="mt-2 fs-12 text-muted mb-0">No test report selected. Please choose a test report to sign...</p>
                    </div>
                </div>
            </div>
        </b-col>
    </BRow>
</template>
<script>
import _ from 'lodash';
import interact from 'interactjs';
import * as pdfjsLib from "pdfjs-dist";
import workerSrc from "pdfjs-dist/build/pdf.worker.min?url";
import { PDFDocument } from 'pdf-lib';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
    props: ['reports','signature'],
    data(){
        return {
            parameters: [{ name: null, result: null }],
            scale: 4.0,
            signaturePos: { x: 0, y: 0 },
            pdfUrl: null,
            pdfDoc: null,
            currentPage: 1,
            totalPages: 0,
            showSignature: false,
            isRendering: false,
            showSave: false,
            currentDateTime: new Date().toLocaleString(),
            selected: null,
            index: null
        }
    },
    mounted() {
        pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;
    },
   
    watch: {
        showSignature(val) {
            if (val && this.$refs.signature) {
                this.$nextTick(() => {
                    const sig = this.$refs.signature;
                    interact(sig).unset();
                    interact(sig).draggable({
                        modifiers: [
                            interact.modifiers.restrictRect({
                                restriction: 'parent'
                            })
                        ],
                        listeners: {
                            move: event => {
                                const target = event.target;
                                const x = (parseFloat(target.dataset.x) || 0) + event.dx;
                                const y = (parseFloat(target.dataset.y) || 0) + event.dy;

                                target.style.left = `${x}px`;
                                target.style.top = `${y}px`;

                                target.dataset.x = x;
                                target.dataset.y = y;

                                this.signaturePos = { x, y };
                            }
                        }
                    });
                });
            }
        }
    },
    methods: {
        renderPdf(selected,index,pageNum = 1) {
            if (!selected) return;
            this.selected = selected;
            this.index = index;

            this.currentPage = pageNum;
            this.showSignature = false;
            this.isRendering = true;

            // PDF URL with cache busting
            this.pdfUrl = `/storage/uploads/testreports/${JSON.parse(this.selected.attachment).name}?v=${Date.now()}`;

            const canvasEl = this.$refs.pdfCanvas;
            const fileUrl = this.pdfUrl;

            const loadingTask = pdfjsLib.getDocument({ url: fileUrl });

            loadingTask.promise.then(pdf => {
                this.totalPages = pdf.numPages;

                if (pageNum < 1) pageNum = 1;
                if (pageNum > pdf.numPages) pageNum = pdf.numPages;

                pdf.getPage(pageNum).then(page => {
                    // Get the viewport with your scale
                    const viewport = page.getViewport({ scale: this.scale });

                    // Set the canvas drawing resolution
                    canvasEl.width = viewport.width;
                    canvasEl.height = viewport.height;

                    const context = canvasEl.getContext('2d');
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext).promise.then(() => {
                        this.isRendering = false;
                    });
                });
            });
        },
        placeSignature() {
            this.showSignature = true;
            this.$nextTick(() => {
                const canvas = this.$refs.pdfCanvas;
                const sig = this.$refs.signature;
                if (!canvas || !sig) return;

                const sigWidth = 100;
                const sigHeight = sig.offsetHeight;

                const centerX = (canvas.offsetWidth - sigWidth) / 2;
                const centerY = (canvas.offsetHeight - sigHeight) / 2;

                sig.style.left = `${centerX}px`;
                sig.style.top = `${centerY}px`;
                sig.dataset.x = centerX;
                sig.dataset.y = centerY;

                this.signaturePos = { x: centerX, y: centerY };
            });
            this.showSave = true;
        },
        async savePdfWithSignature() {
            const signature = this.$refs.signature;
            const canvas = this.$refs.pdfCanvas;
            if (!signature || !canvas) return;

            // Fetch PDF bytes
            const pdfBytes = await fetch(this.pdfUrl).then(res => res.arrayBuffer());

            // Load PDF with pdf-lib
            const pdfDoc = await PDFDocument.load(pdfBytes);

            // Get the page you want to sign (example: first page)
            const page = pdfDoc.getPage(this.currentPage - 1); // zero-indexed

            // Get actual page size in points
            const pdfPageWidth = page.getWidth();
            const pdfPageHeight = page.getHeight();
            

            console.log('PDF size:', pdfPageWidth, pdfPageHeight);

            // Continue your signature positioning logic
            const SIGNATURE_BOX_WIDTH = 230;
            const SIGNATURE_BOX_HEIGHT = 55;

            const canvasRect = canvas.getBoundingClientRect();
            const sigRect = signature.getBoundingClientRect();

            const x = (sigRect.left - canvasRect.left) * (canvas.width / canvasRect.width);
            const y = (sigRect.top - canvasRect.top) * (canvas.height / canvasRect.height);

            const pdfX = x * (pdfPageWidth / canvas.width);
            const pdfY = pdfPageHeight - (y * (pdfPageHeight / canvas.height) + SIGNATURE_BOX_HEIGHT);

            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
            const sigBlob = await fetch(signature.src).then(res => res.blob());
            const timestamp = new Date().toLocaleString();
            const pages = [1,2,3,4];

            const formData = new FormData();
            formData.append('pdf', pdfBlob, 'signed-report.pdf');
            formData.append('signature_image', sigBlob, 'signature.png');
            formData.append('id', this.selected.reference);
            formData.append('timestamp', timestamp);
            formData.append('option', 'report');
            formData.append('role', this.signRole());
            pages.forEach(p => {
                formData.append('page_numbers[]', p);
            });
            formData.append('box_x0', pdfX);
            formData.append('box_y0', pdfY);
            formData.append('box_x1', pdfX + SIGNATURE_BOX_WIDTH);
            formData.append('box_y1', pdfY + SIGNATURE_BOX_HEIGHT);

            this.$inertia.post('/testreports', formData, {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: () => {
                    this.renderPdf(this.reports[this.index]);
                },
                onError: () => (this.errors = this.$page.props.errors),
            });

            this.showSave = false;
        },
        signRole() {

            const userId = this.$page.props.user.data.id;
            const s = this.selected.signatory;
            if(s.analyzed_by === userId && !s.analyzed_date) {
                return 'analyzed';
            }
            if(s.certified_by === userId && !s.certified_date && s.analyzed_date){
                return 'certified';
            }
            if (s.approved_by === userId && !s.approved_date && s.certified_date) {
                return 'approved';
            }
            return null;
        }
    }
}
</script>
