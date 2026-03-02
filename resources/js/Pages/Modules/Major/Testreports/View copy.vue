<template lang="">

    <Head title="View Report" />
    <div class="auth-page-wrapper d-flex min-vh-100">
        <div class="auth-page-content">
            <b-col lg="12">
                <b-card no-body>
                    <div class="bg-info-subtle">
                        <b-card-body class="pb-0 px-4">
                            <b-row class="mb-3">
                                <b-col md>
                                    <b-row class="align-items-center g-3">
                                        <b-col md>
                                            <div>
                                                <h4 class="fw-semibold text-primary">{{(selected.code) ? selected.code : ''}}</h4>
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
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col md="auto">
                                    <div class="hstack gap-4 flex-wrap mt-2">
                                        
                                        <div>  
                                            <b-button variant="primary" block><i class="ri-printer-fill me-1"></i> Print</b-button>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                            
                        </b-card-body>
                    </div>
                </b-card>
            </b-col>
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <div class="file-manager-content w-100 p-4 pb-0" ref="box" style="margin-left: 20px;">
                    <div class="row g-2">
                        <div class="col-sm-12">
                            <div class="row" v-if="selected.lists.length > 0" style="max-height: 130px; overflow: auto;">
                                <div class="col-md-3" v-for="(column, index) in columns" :key="index">
                                    <ul class="list-unstyled">
                                        <li v-for="(item, idx) in column" :key="idx" class="py-1 fs-12">
                                            <i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> {{ item.sample.code }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show mt-n2 mb-0" role="alert">
                                <i class="ri-qr-code-fill label-icon"></i><strong>QR Code</strong> - <span style="cursor: pointer;" @click="printQr()">Click here to print</span>
                            </div>
                            <hr class="text-muted mt-3 mb-2"/>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-1 border border-dashed rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-12">Report Date :</p>
                                        <h5 class="mb-0 fs-12">{{selected.created_at}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-1 border border-dashed rounded mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-12">Released Date :</p>
                                        <h5 class="mb-0 fs-12">-</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" v-if="selected.attachment">
                            <div class="border rounded border-dashed p-1 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-text-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-12">Download PDF :</p>
                                        <h5 class="mb-0 fs-12">{{selected.code+'.pdf'}}</h5>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <div class="d-flex gap-1">
                                            <button type="button" @click="openPdf" class="btn btn-icon text-muted btn-sm fs-18"><i class="ri-download-2-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr class="text-muted mt-n2"/>
                            <div class="card bg-light-subtle shadow-none border">
                                <div class="card-header bg-light-subtle">
                                    <div class="d-flex mb-n3">
                                        <div class="flex-shrink-0 me-3">
                                            <div style="height:2.5rem;width:2.5rem;">
                                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                                    <i class="ri-team-fill text-primary fs-22"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-0 fs-13"><span class="text-body">List of Signatories</span></h5>
                                            <p class="text-muted text-truncate-two-lines fs-12">This is the list of individuals authorized to sign and who have signed the report.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-white border-bottom shadow-none" no-body>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-striped align-middle mb-0">
                                            <thead class="table-light thead-fixed">
                                                <tr class="fs-11">
                                                    <th class="text-center" width="7%">#</th>
                                                    <th>Name</th>
                                                    <th class="text-center" width="30%">Timestamp</th>
                                                </tr>
                                            </thead>
                                            <!-- <tbody v-if="this.testreport.data.signatories.length > 0">
                                                <tr v-for="(list,index) in this.testreport.data.signatories" v-bind:key="index">
                                                    <td class="text-center"> 
                                                        {{index + 1}}
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-13 mb-0">{{list.user.profile.fullname}}</h5>
                                                    </td>
                                                    <td class="text-center">{{list.timestamp}}</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted fs-12">No signatories found.</td>
                                                </tr>
                                            </tbody> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                </div>
                <div class="file-manager-sidebar" style="margin-right: 20px;">
                    <div class="row p-4">
                        <div class="col-md-12">  
                            <b-row class="mb-0">
                                <b-col md>
                                    <div class="hstack gap-1 flex-wrap">
                                        <div>  
                                            <b-button @click="savePdfWithSignature" variant="primary" block><i class="ri-save-fill me-1"></i> Save</b-button>
                                        </div>
                                        <div v-if="!showSignature" @click="placeSignature">  
                                            <b-button variant="warning" block><i class="ri-ball-pen-fill me-1"></i>Sign</b-button>
                                        </div>
                                        <div>  
                                            <b-button @click="renderPdf()" variant="light" block><i class="ri-refresh-fill"></i></b-button>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="auto">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
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
                        </div>
                        <div class="col-md-12 position-relative" style="height: calc(100vh - 290px); overflow: auto;">
                            <div ref="pdfContainer" class="position-relative w-100">
                            <img
                                v-show="showSignature"
                                ref="signature"
                                src="/images/esig.png"
                                id="signature"
                                style="position: absolute; width: 100px; cursor: move;"
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
                        <div class="col-md-12 mt-3">
                            <file-pond name="pdf" ref="pond" allow-multiple="false" max-files="1" accepted-file-types="application/pdf"
                            label-idle='Drag & Drop your PDF or <span class="filepond--label-action">Browse</span>' 
                            :allow-process="false" @addfile="handleAddFile"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <Message ref="message" />
</template>
<script>
import { PDFDocument, rgb, StandardFonts } from 'pdf-lib';
import interact from 'interactjs';
const pdfjsLib = window['pdfjs-dist/build/pdf'];

pdfjsLib.GlobalWorkerOptions.workerSrc =
  'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import Message from './Modals/Message.vue';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
const FilePond = vueFilePond(FilePondPluginFileValidateType);
import simplebar from "simplebar-vue";
import PageHeader from '@/Shared/Components/PageHeader.vue';
    export default {
        layout: null,
        props: ['testreport'],
        components: { PageHeader, simplebar, Message, FilePond },
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
        data(){
            return {
                selected: this.testreport.data,
                parameters: [{ name: null, result: null }],
                scale: 4.0,
                signaturePos: { x: 0, y: 0 },
                pdfUrl: null,
                pdfDoc: null,
                currentPage: 1,
                totalPages: 0,
                showSignature: false,
                isRendering: false,
                currentDateTime: new Date().toLocaleString(),
            }
        },
        mounted() {
            this.renderPdf();
            this.makeDraggable();
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
            renderPdf(pageNum = 1) {
                if(this.selected.attachment){
                    this.currentPage = pageNum;
                    this.showSignature = false;
                    this.isRendering = true;
                    this.pdfUrl = `/storage/uploads/testreports/${this.selected.attachment.name}?v=${Date.now()}`;
                    const canvasEl = this.$refs.pdfCanvas;
                    const fileUrl = this.pdfUrl;
                
                    const loadingTask = pdfjsLib.getDocument(fileUrl);

                    loadingTask.promise.then(pdf => {
                        this.totalPages = pdf.numPages;

                        if (pageNum < 1) pageNum = 1;
                        if (pageNum > pdf.numPages) pageNum = pdf.numPages;

                        pdf.getPage(pageNum).then(page => {
                            const viewport = page.getViewport({ scale: this.scale });

                            canvasEl.width = viewport.width;
                            canvasEl.height = viewport.height;

                            const context = canvasEl.getContext('2d');

                            const renderContext = {
                                canvasContext: context,
                                viewport: viewport,
                            };

                            page.render(renderContext).promise.then(() => {
                                this.isRendering = false;
                            });
                        });
                    });
                }
            },
            async savePdfWithSignature() {
                const signature = this.$refs.signature;
                const canvas = this.$refs.pdfCanvas;

                const sigBlob = await fetch(signature.src).then(res => res.blob());
                const sigArrayBuffer = await sigBlob.arrayBuffer();

                const pdfBytes = await fetch(this.pdfUrl).then(res => res.arrayBuffer());
                const pdfDoc = await PDFDocument.load(pdfBytes);
                const page = pdfDoc.getPages()[this.currentPage - 1];

                const img = await pdfDoc.embedPng(sigArrayBuffer);
                const sigWidthCSS = signature.offsetWidth;
                const sigHeightCSS = signature.offsetHeight;

                const scaleX = page.getWidth() / canvas.offsetWidth;
                const scaleY = page.getHeight() / canvas.offsetHeight;

                const sigX = parseFloat(signature.dataset.x) || 0;
                const sigY = parseFloat(signature.dataset.y) || 0;

                const sigXPDF = sigX * scaleX;
                const sigWidthPDF = sigWidthCSS * scaleX;
                const sigHeightPDF = sigHeightCSS * scaleY;

                const cssYOffsetCorrection = 0; //36
                const yOffsetCorrection = cssYOffsetCorrection * scaleY;

                const sigYPDF = page.getHeight() - ((sigY + sigHeightCSS) * scaleY) + yOffsetCorrection;

                page.drawImage(img, {
                    x: sigXPDF,
                    y: sigYPDF,
                    width: sigWidthPDF,
                    height: sigHeightPDF,
                });

                this.currentDateTime = new Date().toLocaleString();
                const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
                const title = 'DIGITALLY SIGNED BY';
                const name = 'RA-OUF I. JUMLI';
                const timestamp = this.currentDateTime;
                const textX = sigXPDF + sigWidthPDF + 10;
                const textY = sigYPDF + sigHeightPDF - 10;

                page.drawText(title, {
                    x: textX,
                    y: textY,
                    size: 5,
                    font,
                    color: rgb(0, 0, 1),
                });

                page.drawText(name, {
                    x: textX,
                    y: textY - 6,
                    size: 5,
                    font,
                    color: rgb(0, 0, 1),
                });

                page.drawText(timestamp, {
                    x: textX,
                    y: textY - 12,
                    size: 5,
                    font,
                    color: rgb(0, 0, 1),
                });

                const pdfBytesSigned = await pdfDoc.save();
                const blob = new Blob([pdfBytesSigned], { type: 'application/pdf' });

                const formData = new FormData();
                formData.append('pdf', blob, 'signed-report.pdf');
                formData.append('id', this.selected.reference);
                formData.append('timestamp',timestamp);
                formData.append('option', 'report');

                this.$inertia.post('/testreports', formData, {
                    preserveScroll: true,
                    forceFormData: true,
                    onSuccess: () => this.renderPdf?.(),
                    onError: () => {
                    this.errors = this.$page.props.errors;
                    }
                });
            },
            handleAddFile(error, fileItem) {
                if (error) return console.error('FilePond error:', error);

                const file = fileItem.file;
                const formData = new FormData();
                formData.append('pdf', file);
                formData.append('id', this.selected.reference);
                formData.append('option', 'report');

                this.$inertia.post('/testreports', formData, {
                    preserveScroll: true,
                    forceFormData: true,
                    onSuccess: (page) => {
                        // Update selected.attachment with new data from backend
                   
                        if (page.props.flash) {
                            this.selected.attachment = page.props.flash.data;
                        }

                        // Cache busting
                        this.pdfUrl = `/storage/uploads/testreports/${this.selected.attachment.name}?v=${Date.now()}`;

                        // Render updated PDF
                        setTimeout(() => {
                            this.renderPdf(this.currentPage);
                        }, 300);
                    },
                    onError: () => this.errors = this.$page.props.errors
                });
            },
            makeDraggable() {
                interact(this.$refs.signature).draggable({
                    modifiers: [interact.modifiers.restrictRect({ restriction: 'parent' })],
                    listeners: {
                    move: event => {
                        const target = event.target;
                        const x = (parseFloat(target.dataset.x) || 0) + event.dx;
                        const y = (parseFloat(target.dataset.y) || 0) + event.dy;
                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.dataset.x = x;
                        target.dataset.y = y;
                        this.signaturePos = { x, y };
                    }
                    }
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
            },
            goToPage(page) {
                this.currentPage = page;
                this.renderPdf(page);
            },
            printQr(){
                window.open('/testreports?option=qrcode&id='+this.selected.qr);
            },
            openPdf() {
                window.open(this.pdfUrl, '_blank');
            }
        }
    }
</script>
<style scoped>
    .auth-page-wrapper .auth-page-content {
        padding-bottom: 0px;
        width: 100%;
        overflow: hidden;
        background-color: #f3f3f9;
    }
    .file-manager-sidebar {
        min-width: 50%;
        max-width: 50%;
        height: calc(100vh - 92px);
    }
    #signature {
        position: absolute;
        z-index: 10;
    }
    .loading-overlay-inside {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 100%;
    background-color: rgba(255, 255, 255, 0.6); /* Adjust if needed */
    backdrop-filter: blur(2px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
    pointer-events: all;
}
</style>
