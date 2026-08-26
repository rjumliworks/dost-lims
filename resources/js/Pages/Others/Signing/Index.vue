<template lang="">

    <Head title="PDF Signing" />
    <PageHeader title="Signing Document" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="w-100 p-4 pb-0" ref="box">
            <BRow>
                <b-col lg="12">
                    <b-card no-body class="mt-n4 mx-n4">
                        <div class="bg-info-subtle">
                            <b-card-body class="pb-0 px-4">
                                <b-row class="mb-3 align-items-center">
                                    <b-col md>
                                        <h4 class="fw-semibold text-primary mb-0">PDF Signing</h4>
                                        <p class="text-muted fs-12 mb-0">Upload a PDF and apply your PNPKI signature. The file is only kept in your browser — nothing is saved until you download it.</p>
                                    </b-col>
                                    <b-col md="auto" v-if="pdfFile">
                                        <div class="hstack gap-2 flex-wrap mt-2">
                                            <b-button variant="light" @click="reset"><i class="ri-close-line me-1"></i>Clear</b-button>
                                            <b-button variant="success" @click="downloadSigned" :disabled="!signedBlobUrl"><i class="ri-download-2-line me-1"></i>Download Signed PDF</b-button>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </div>
                    </b-card>
                </b-col>

                <div class="p-4" v-if="!pdfFile">
                <file-pond name="pdf" ref="pond" allow-multiple="false" max-files="1" accepted-file-types="application/pdf"
                    label-idle='Drag &amp; Drop a PDF here or <span class="filepond--label-action">Browse</span>'
                    :allow-process="false" @addfile="handleAddFile"/>
                <div class="text-muted fs-12 mt-2" v-if="normalizing"><span class="spinner-border spinner-border-sm me-1"></span>Normalizing PDF...</div>
                <div class="text-danger fs-12 mt-2" v-if="errors">{{ errors }}</div>
            </div>

            <div class="p-4 pt-0" v-else>
                <div class="text-danger fs-12 mb-2" v-if="errors">{{ errors }}</div>
                <b-row class="mb-2">
                    <b-col md>
                        <div class="hstack gap-1 flex-wrap">
                            <div v-if="!showSignature" @click="placeSignature">
                                <b-button variant="warning" block><i class="ri-ball-pen-fill me-1"></i>Sign</b-button>
                            </div>
                            <div v-if="showSignature && isPlacing" class="align-self-center text-muted fs-12">
                                Click inside the PDF to place the signature...
                            </div>
                            <div v-if="showSignature && !isPlacing">
                                <b-button variant="primary" @click="applySignature" :disabled="signing" block>
                                    <span v-if="signing"><span class="spinner-border spinner-border-sm me-1"></span>Signing...</span>
                                    <span v-else><i class="ri-check-line me-1"></i>Apply Signature</span>
                                </b-button>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="auto">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item" :class="{ disabled: currentPage === 1 }" @click="goToPage(currentPage - 1)">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }" @click="goToPage(page)">
                                    <a class="page-link" href="#">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: currentPage === totalPages }" @click="goToPage(currentPage + 1)">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </b-col>
                </b-row>

                <div class="position-relative" style="height: calc(100vh - 360px); overflow: auto;">
                    <div ref="pdfContainer" class="position-relative w-100">
                        <img
                            v-show="showSignature"
                            ref="signature"
                            :src="signature"
                            id="signature"
                            :style="{ position: 'absolute', width: 'auto', height: signaturePreviewHeightPx + 'px', cursor: 'move' }"
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
            </div>

            </BRow>
            <!-- <b-col lg="12">
                <b-card no-body>
                    <div class="bg-info-subtle">
                        <b-card-body class="pb-0 px-4">
                            <b-row class="mb-3 align-items-center">
                                <b-col md>
                                    <h4 class="fw-semibold text-primary mb-0">PDF Signing</h4>
                                    <p class="text-muted fs-12 mb-0">Upload a PDF and apply your PNPKI signature. The file is only kept in your browser — nothing is saved until you download it.</p>
                                </b-col>
                                <b-col md="auto" v-if="pdfFile">
                                    <div class="hstack gap-2 flex-wrap mt-2">
                                        <b-button variant="light" @click="reset"><i class="ri-close-line me-1"></i>Clear</b-button>
                                        <b-button variant="success" @click="downloadSigned" :disabled="!signedBlobUrl"><i class="ri-download-2-line me-1"></i>Download Signed PDF</b-button>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </div>
                </b-card>
            </b-col>


            <div class="p-4" v-if="!pdfFile">
                <file-pond name="pdf" ref="pond" allow-multiple="false" max-files="1" accepted-file-types="application/pdf"
                    label-idle='Drag &amp; Drop a PDF here or <span class="filepond--label-action">Browse</span>'
                    :allow-process="false" @addfile="handleAddFile"/>
                <div class="text-muted fs-12 mt-2" v-if="normalizing"><span class="spinner-border spinner-border-sm me-1"></span>Normalizing PDF...</div>
                <div class="text-danger fs-12 mt-2" v-if="errors">{{ errors }}</div>
            </div>

            <div class="p-4 pt-0" v-else>
                <div class="text-danger fs-12 mb-2" v-if="errors">{{ errors }}</div>
                <b-row class="mb-2">
                    <b-col md>
                        <div class="hstack gap-1 flex-wrap">
                            <div v-if="!showSignature" @click="placeSignature">
                                <b-button variant="warning" block><i class="ri-ball-pen-fill me-1"></i>Sign</b-button>
                            </div>
                            <div v-if="showSignature && isPlacing" class="align-self-center text-muted fs-12">
                                Click inside the PDF to place the signature...
                            </div>
                            <div v-if="showSignature && !isPlacing">
                                <b-button variant="primary" @click="applySignature" :disabled="signing" block>
                                    <span v-if="signing"><span class="spinner-border spinner-border-sm me-1"></span>Signing...</span>
                                    <span v-else><i class="ri-check-line me-1"></i>Apply Signature</span>
                                </b-button>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="auto">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item" :class="{ disabled: currentPage === 1 }" @click="goToPage(currentPage - 1)">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }" @click="goToPage(page)">
                                    <a class="page-link" href="#">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: currentPage === totalPages }" @click="goToPage(currentPage + 1)">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </b-col>
                </b-row>

                <div class="position-relative" style="height: calc(100vh - 260px); overflow: auto;">
                    <div ref="pdfContainer" class="position-relative w-100">
                        <img
                            v-show="showSignature"
                            ref="signature"
                            :src="signature"
                            id="signature"
                            :style="{ position: 'absolute', width: 'auto', height: signaturePreviewHeightPx + 'px', cursor: 'move' }"
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
            </div> -->
        </div>
    </div>
  </template>
<script>
import interact from 'interactjs';
import * as pdfjsLib from "pdfjs-dist";
import workerSrc from "pdfjs-dist/build/pdf.worker.min?url";
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
const FilePond = vueFilePond(FilePondPluginFileValidateType);
import PageHeader from '@/Shared/Components/PageHeader.vue';
import { PDFDocument } from 'pdf-lib';

const SIGNATURE_BOX_HEIGHT = 55; // PDF points — fixed so the signature always prints at the same size

    export default {
        props: ['signature'],
        components: { PageHeader, FilePond },
        data(){
            return {
                pdfFile: null,
                pdfObjectUrl: null,
                signedBlobUrl: null,
                scale: 2.0,
                signaturePos: { x: 0, y: 0 },
                currentPage: 1,
                totalPages: 0,
                showSignature: false,
                isPlacing: false,
                isRendering: false,
                signing: false,
                normalizing: false,
                errors: null,
                pdfPageHeight: 0,
                canvasHeightPx: 0,
            }
        },
        computed: {
            // The preview's on-screen height is derived from the canvas's
            // current rendered size so it always visually represents exactly
            // SIGNATURE_BOX_HEIGHT points — this way the box the user sees is
            // never bigger or smaller than what actually gets pasted onto the
            // PDF, regardless of window size or zoom.
            signaturePreviewHeightPx() {
                if (!this.pdfPageHeight || !this.canvasHeightPx) return 120;
                return (SIGNATURE_BOX_HEIGHT / this.pdfPageHeight) * this.canvasHeightPx;
            },
        },
        mounted() {
            pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;
            window.addEventListener('resize', this.updateCanvasMetrics);
        },
        beforeUnmount() {
            window.removeEventListener('resize', this.updateCanvasMetrics);
        },
        methods: {
            updateCanvasMetrics() {
                const canvas = this.$refs.pdfCanvas;
                if (!canvas) return;
                this.canvasHeightPx = canvas.getBoundingClientRect().height;
            },
            // Signature-placement flow: click "Sign" to arm placement mode —
            // the signature image tracks the cursor (via followCursor, bound to
            // the PDF container so it stays correct even if the container was
            // scrolled) until the user clicks inside the PDF to drop it
            // (dropSignature). Only after it's dropped does interact.js take
            // over for fine-tune dragging (enableDragging).
            followCursor(e) {
                if (!this.isPlacing) return;
                const sig = this.$refs.signature;
                const container = this.$refs.pdfContainer;
                if (!sig || !container) return;

                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left - sig.offsetWidth / 2;
                const y = e.clientY - rect.top - sig.offsetHeight / 2;

                sig.style.left = `${x}px`;
                sig.style.top = `${y}px`;
            },
            dropSignature(e) {
                if (!this.isPlacing) return;
                const sig = this.$refs.signature;
                const container = this.$refs.pdfContainer;
                if (!sig || !container) return;

                container.removeEventListener('mousemove', this.followCursor);
                container.removeEventListener('click', this.dropSignature);

                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left - sig.offsetWidth / 2;
                const y = e.clientY - rect.top - sig.offsetHeight / 2;

                sig.style.left = `${x}px`;
                sig.style.top = `${y}px`;
                sig.dataset.x = x;
                sig.dataset.y = y;
                this.signaturePos = { x, y };

                this.isPlacing = false;
                this.enableDragging();
            },
            enableDragging() {
                const sig = this.$refs.signature;
                if (!sig) return;

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
            },
            cancelPlacement() {
                const container = this.$refs.pdfContainer;
                if (container) {
                    container.removeEventListener('mousemove', this.followCursor);
                    container.removeEventListener('click', this.dropSignature);
                }
                this.isPlacing = false;
            },
            handleAddFile(error, fileItem) {
                if (error) return console.error('FilePond error:', error);

                this.errors = null;
                this.normalizing = true;

                const file = fileItem.file;
                const formData = new FormData();
                formData.append('option', 'normalize');
                formData.append('pdf', file, file.name || 'document.pdf');

                this.$inertia.post('/digitalsigning', formData, {
                    preserveScroll: true,
                    preserveState: true,
                    forceFormData: true,
                    onSuccess: (page) => {
                        const flash = page.props.flash;

                        if (flash && flash.status !== false && flash.data) {
                            const bytes = Uint8Array.from(atob(flash.data), c => c.charCodeAt(0));
                            const blob = new Blob([bytes], { type: 'application/pdf' });

                            this.currentPage = 1;
                            this.signedBlobUrl = null;
                            this.pdfFile = new File([blob], file.name || 'document.pdf', { type: 'application/pdf' });
                            this.loadPdf(this.pdfFile);
                        } else {
                            this.errors = (flash && flash.info) || 'Failed to normalize the PDF.';
                        }

                        this.normalizing = false;
                    },
                    onError: () => {
                        this.errors = 'Failed to normalize the PDF.';
                        this.normalizing = false;
                    },
                });
            },
            loadPdf(file) {
                if (this.pdfObjectUrl) URL.revokeObjectURL(this.pdfObjectUrl);
                this.pdfObjectUrl = URL.createObjectURL(file);

                this.$nextTick(() => {
                    this.renderPdf(this.currentPage);
                });
            },
            renderPdf(pageNum = 1) {
                if (!this.pdfObjectUrl) return;

                const canvasEl = this.$refs.pdfCanvas;
                if (!canvasEl) return;

                this.currentPage = pageNum;
                this.cancelPlacement();
                this.showSignature = false;
                this.isRendering = true;

                const fileUrl = this.pdfObjectUrl;

                const loadingTask = pdfjsLib.getDocument({ url: fileUrl });

                loadingTask.promise.then(pdf => {
                    this.totalPages = pdf.numPages;

                    if (pageNum < 1) pageNum = 1;
                    if (pageNum > pdf.numPages) pageNum = pdf.numPages;

                    pdf.getPage(pageNum).then(page => {
                        const viewport = page.getViewport({ scale: this.scale });

                        canvasEl.width = viewport.width;
                        canvasEl.height = viewport.height;
                        this.pdfPageHeight = viewport.height / this.scale;

                        const context = canvasEl.getContext('2d');
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(() => {
                            this.isRendering = false;
                            this.$nextTick(this.updateCanvasMetrics);
                        });
                    });
                });
            },
            placeSignature() {
                this.showSignature = true;
                this.isPlacing = true;
                this.$nextTick(() => {
                    const container = this.$refs.pdfContainer;
                    if (!container) return;

                    container.addEventListener('mousemove', this.followCursor);
                    container.addEventListener('click', this.dropSignature);
                });
            },
            async applySignature() {
                const signature = this.$refs.signature;
                const canvas = this.$refs.pdfCanvas;
                if (!signature || !canvas || !this.pdfFile) return;

                this.errors = null;
                this.signing = true;

                const pdfBytes = await this.pdfFile.arrayBuffer();
                const pdfDoc = await PDFDocument.load(pdfBytes);
                const page = pdfDoc.getPage(this.currentPage - 1);

                const pdfPageWidth = page.getWidth();
                const pdfPageHeight = page.getHeight();

                const canvasRect = canvas.getBoundingClientRect();
                const sigRect = signature.getBoundingClientRect();

                const ptPerPxX = pdfPageWidth / canvasRect.width;
                const ptPerPxY = pdfPageHeight / canvasRect.height;

                // The preview's on-screen height is already sized (see
                // signaturePreviewHeightPx) to visually represent exactly
                // SIGNATURE_BOX_HEIGHT points at the current canvas render
                // scale, so mapping its on-screen rectangle straight into PDF
                // point space both keeps the box at that fixed physical size
                // and lands it exactly where it was dropped.
                const boxWidth = sigRect.width * ptPerPxX;
                const boxHeight = sigRect.height * ptPerPxY;

                const pdfX = (sigRect.left - canvasRect.left) * ptPerPxX;
                const pdfTopY = pdfPageHeight - (sigRect.top - canvasRect.top) * ptPerPxY;
                const pdfY = pdfTopY - boxHeight;

                const formData = new FormData();
                formData.append('option', 'sign');
                formData.append('pdf', this.pdfFile, this.pdfFile.name || 'document.pdf');
                formData.append('field_name', 'signature_' + Date.now());
                formData.append('page_number', this.currentPage);
                formData.append('box_x0', pdfX);
                formData.append('box_y0', pdfY);
                formData.append('box_x1', pdfX + boxWidth);
                formData.append('box_y1', pdfY + boxHeight);

                this.$inertia.post('/digitalsigning', formData, {
                    preserveScroll: true,
                    preserveState: true,
                    forceFormData: true,
                    onSuccess: (page) => {
                        const flash = page.props.flash;

                        if (flash && flash.status !== false && flash.data) {
                            const bytes = Uint8Array.from(atob(flash.data), c => c.charCodeAt(0));
                            const blob = new Blob([bytes], { type: 'application/pdf' });

                            if (this.pdfObjectUrl) URL.revokeObjectURL(this.pdfObjectUrl);

                            this.pdfFile = new File([blob], this.pdfFile.name || 'signed.pdf', { type: 'application/pdf' });
                            this.pdfObjectUrl = URL.createObjectURL(blob);
                            this.signedBlobUrl = this.pdfObjectUrl;

                            this.showSignature = false;
                            this.renderPdf(this.currentPage);
                        } else {
                            this.errors = (flash && flash.info) || 'Failed to sign the PDF.';
                        }

                        this.signing = false;
                    },
                    onError: () => {
                        this.errors = 'Failed to sign the PDF.';
                        this.signing = false;
                    },
                });
            },
            downloadSigned() {
                if (!this.signedBlobUrl) return;

                const a = document.createElement('a');
                a.href = this.signedBlobUrl;
                a.download = this.pdfFile?.name || 'signed.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();
            },
            reset() {
                if (this.pdfObjectUrl) URL.revokeObjectURL(this.pdfObjectUrl);

                this.cancelPlacement();
                this.pdfFile = null;
                this.pdfObjectUrl = null;
                this.signedBlobUrl = null;
                this.showSignature = false;
                this.currentPage = 1;
                this.totalPages = 0;
                this.errors = null;

                if (this.$refs.pond) this.$refs.pond.removeFiles();
            },
            goToPage(page) {
                if (page < 1 || page > this.totalPages) return;

                this.cancelPlacement();
                this.showSignature = false;
                this.currentPage = page;

                this.renderPdf(page);
            },
        }
    }
</script>
<style scoped>
    .auth-page-wrapper .auth-page-content {
        padding-bottom: 0px;
        overflow: hidden;
        background-color: #f3f3f9;
    }
</style>
