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
                
                <div class="card bg-white border-bottom shadow-none" no-body v-if="!selected">
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
                <div class="bg-white rounded-bottom shadow-none" style="height: calc(100vh - 292px);" no-body v-else>
                    <div class="row g-2 p-3">
                        <div class="col-sm-12">
                            <div class="p-1 border border-dashed rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-12">Report Number :</p>
                                        <h5 class="mb-0 fs-12 fw-semibold text-primary">{{selected.code}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr class="text-muted mt-1 mb-1"/>
                            <p class="ms-1 mt-3 mb-0 text-primary fs-12 fw-semibold flex-grow-1">List of Samples : </p>
                            <div v-for="(row, rowIndex) in chunkedTags" :key="rowIndex" class="mb-1 mt-2">
                                <ul class="list-unstyled fs-12 mb-0 d-flex">
                                    <li class="py-0 me-3 d-flex align-items-center" style="min-width: 160px;" v-for="(list, index) in row" :key="index">
                                        <i class="mdi mdi-circle-medium me-1 text-muted"></i> {{ list.sample.code}}
                                    </li>
                                </ul>
                            </div>
                            <hr class="text-muted mt-3 mb-1"/>
                        </div>
                        <div class="col-sm-12">
                            <div class="profile-timeline ms-n2">

                                <!-- Analyzed -->
                                <div class="accordion-item border-0">
                                    <div class="accordion-header">
                                        <a class="accordion-button p-2 shadow-none"
                                            :class="{ collapsed: activeCollapse !== 'analyzed' }"
                                            href="javascript:void(0)"
                                            @click="toggleCollapse('analyzed')">

                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <i
                                                            class="fs-18"
                                                            :class="selected.signatory.analyzed_date
                                                                ? 'ri-checkbox-circle-fill text-success'
                                                                : 'ri-time-line text-warning'"
                                                        ></i>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-12 mb-0"> {{ selected.signatory.analyzed?.profile?.fullname || 'Not Assigned' }}</h6>
                                                    <small class="text-muted">
                                                       Analyzed By
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div v-show="activeCollapse === 'analyzed'" class="accordion-body ms-4 ps-4 pt-0">
            
                                        <table class="table table-nowrap table-bordered align-middle table-sm">
                                            <thead class="table-light thead-fixed">
                                                <tr class="fs-11">
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center" width="50%">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"> 
                                                        <span class="badge" :class="selected.signatory.analyzed_date ? 'bg-success' : 'bg-warning'">
                                                        {{ selected.signatory.analyzed_date ? 'Completed' : 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ (selected.signatory.analyzed_date) ?? '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Certified -->
                                <div class="accordion-item border-0">
                                    <div class="accordion-header">
                                        <a class="accordion-button p-2 shadow-none"
                                            :class="{ collapsed: activeCollapse !== 'certified' }"
                                            href="javascript:void(0)"
                                            @click="toggleCollapse('certified')">

                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <i
                                                            class="fs-18"
                                                            :class="selected.signatory.certified_date
                                                                ? 'ri-checkbox-circle-fill text-success'
                                                                : 'ri-time-line text-warning'"
                                                        ></i>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-12 mb-0">{{ selected.signatory.certified?.profile?.fullname || 'Not Assigned' }}</h6>
                                                    <small class="text-muted">
                                                        Certified By
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div v-show="activeCollapse === 'certified'" class="accordion-body ms-2 ps-4 pt-0">
                                        <table class="table table-nowrap table-bordered align-middle table-sm">
                                            <thead class="table-light thead-fixed">
                                                <tr class="fs-11">
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center" width="50%">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"> 
                                                        <span class="badge" :class="selected.signatory.certified_date ? 'bg-success' : 'bg-warning'">
                                                        {{ selected.signatory.certified_date ? 'Completed' : 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ (selected.signatory.certified_date) ?? '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Approved -->
                                <div class="accordion-item border-0">
                                    <div class="accordion-header">
                                        <a class="accordion-button p-2 shadow-none"
                                            :class="{ collapsed: activeCollapse !== 'approved' }"
                                            href="javascript:void(0)"
                                            @click="toggleCollapse('approved')">

                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <i
                                                            class="fs-18"
                                                            :class="selected.signatory.approved_date
                                                                ? 'ri-checkbox-circle-fill text-success'
                                                                : 'ri-time-line text-warning'"
                                                        ></i>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-12 mb-0">{{ selected.signatory.approved?.profile?.fullname || 'Not Assigned' }}</h6>
                                                    <small class="text-muted">
                                                        Approved By
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div v-show="activeCollapse === 'approved'" class="accordion-body ms-2 ps-4 pt-0">
                                        <table class="table table-nowrap table-bordered align-middle table-sm">
                                            <thead class="table-light thead-fixed">
                                                <tr class="fs-11">
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center" width="50%">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"> 
                                                        <span class="badge" :class="selected.signatory.approved_date ? 'bg-success' : 'bg-warning'">
                                                        {{ selected.signatory.approved_date ? 'Completed' : 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ (selected.signatory.approved_date) ?? '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr class="text-muted mt-1 mb-1"/>
                            </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-2">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-file-text-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">TSR Code :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.tsr.code}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-2">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-todo-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Due Date :</p>
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.tsr.due_at}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-2">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Date Created :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.created_at}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-2">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-account-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Created By :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.user.profile.fullname}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12">
                            <hr class="text-muted mt-3 mb-1"/>
                        </div> -->
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
                            <p class="text-muted text-truncate-two-lines fs-12">Click <strong>Sign</strong> and <strong>Save</strong> to complete the process.</p>
                        </div>
                        <div class="flex-shrink-0" style="width: 45%;">
                            <div class="float-end" v-if="showSave">
                                <b-button variant="primary" class="w-sm" @click="savePdfWithSignature" block><i class="ri-save-fill me-2"></i> Save</b-button>
                            </div>
                            <div v-if="showSignature && isPlacing" class="float-end text-muted fs-12 align-self-center me-2">
                                Click inside the PDF to place the signature...
                            </div>
                            <div v-if="!showSignature" class="float-end" @click="placeSignature">
                                <b-button variant="warning" class="w-sm" block><i class="ri-ball-pen-fill me-2"></i>Sign</b-button>
                            </div>
                            <div class="float-end" @click="selected = null">
                                <b-button variant="light" class="w-sm me-2"  block><i class="ri-close-circle-fill text-danger me-2"></i>Close</b-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom" :style="{ height: selected ? 'calc(100vh - 292px)' : 'calc(100vh - 292px)', overflow: 'auto'}" v-if="selected">
                    <b-row class="mb-2" v-if="totalPages > 1">
                        <b-col class="d-flex justify-content-end">
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
                    <div ref="pdfContainer" class="position-relative w-100">
                        <img
                            v-show="showSignature"
                            ref="signature"
                            :src="signature"
                            id="signature"
                            style="position: absolute; width: auto; height: 120px; cursor: move;"
                        />
                        <canvas ref="pdfCanvas" id="pdfcanvas" class="border border-dashed rounded" style="width: 100%; height: auto;"></canvas>
                        <div v-if="isRendering" class="loading-overlay-inside">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body rounded-bottom"  style="height: calc(100vh - 224px); overflow: auto;" v-if="!selected">
                     <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        
                        <img src="/images/icons/contract.png" style="height:80px;" class="mb-3"/>
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
            isPlacing: false,
            isRendering: false,
            showSave: false,
            currentDateTime: new Date().toLocaleString(),
            selected: null,
            index: null,
            activeCollapse: null
        }
    },
    mounted() {
        pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;
        this.openFromQuery();
    },
    computed: {
        chunkedTags() {
            const tags = this.selected.lists || [];
            let chunkSize = 3;

            if (tags.length >= 6) chunkSize = 2;  
            else if (tags.length >= 4) chunkSize = 2; 

            const chunks = [];
            for (let i = 0; i < tags.length; i += chunkSize) {
                chunks.push(tags.slice(i, i + chunkSize));
            }
            return chunks;
        },
    },
    methods: {
        openFromQuery(){
            const params = new URLSearchParams(window.location.search);
            const reference = params.get('open');
            if(!reference) return;

            const index = this.reports.findIndex(report => report.reference === reference);
            if(index !== -1){
                this.renderPdf(this.reports[index], index);
            }

            params.delete('open');
            const query = params.toString();
            history.replaceState({}, '', window.location.pathname + (query ? '?' + query : ''));
        },
        async renderPdf(selected, index, pageNum = 1) {
            if (!selected) return;

            this.selected = selected;
            this.index = index;

            await this.$nextTick();

            const canvasEl = this.$refs.pdfCanvas;

            if (!canvasEl) {
                console.error('pdfCanvas ref not found');
                return;
            }

            this.currentPage = pageNum;
            this.cancelPlacement();
            this.showSignature = false;
            this.isRendering = true;

            this.pdfUrl = `/storage/uploads/testreports/${
                JSON.parse(this.selected.attachment).name
            }?v=${Date.now()}`;

            const loadingTask = pdfjsLib.getDocument({
                url: this.pdfUrl
            });

            try {
                const pdf = await loadingTask.promise;

                this.totalPages = pdf.numPages;

                pageNum = Math.max(1, Math.min(pageNum, pdf.numPages));

                const page = await pdf.getPage(pageNum);

                const viewport = page.getViewport({
                    scale: this.scale
                });

                canvasEl.width = viewport.width;
                canvasEl.height = viewport.height;

                const context = canvasEl.getContext('2d');

                await page.render({
                    canvasContext: context,
                    viewport
                }).promise;

                this.isRendering = false;
            } catch (error) {
                console.error(error);
                this.isRendering = false;
            }
        },
        // Signature-placement flow: click "Sign" to arm placement mode — the
        // signature image tracks the cursor (via followCursor, bound to the
        // PDF container so it stays correct even if the container was
        // scrolled) until the user clicks inside the PDF to drop it
        // (dropSignature). Only after it's dropped does interact.js take over
        // for fine-tune dragging (enableDragging).
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
            this.showSave = true;
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

            // Map the preview's on-screen rectangle straight into PDF point
            // space, 1:1 — no hardcoded box size, matching how the digital
            // signing tool (Others/Signing) computes it. Whatever rectangle
            // is drawn on screen is exactly what gets sent to the backend as
            // the signature image's box.
            const canvasRect = canvas.getBoundingClientRect();
            const sigRect = signature.getBoundingClientRect();

            const ptPerPxX = pdfPageWidth / canvasRect.width;
            const ptPerPxY = pdfPageHeight / canvasRect.height;

            const boxWidth = sigRect.width * ptPerPxX;
            const boxHeight = sigRect.height * ptPerPxY;

            const pdfX = (sigRect.left - canvasRect.left) * ptPerPxX;
            const pdfTopY = pdfPageHeight - (sigRect.top - canvasRect.top) * ptPerPxY;
            const pdfY = pdfTopY - boxHeight;

            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
            const sigBlob = await fetch(signature.src).then(res => res.blob());
            const timestamp = new Date().toLocaleString();

            const formData = new FormData();
            formData.append('pdf', pdfBlob, 'signed-report.pdf');
            formData.append('signature_image', sigBlob, 'signature.png');
            formData.append('id', this.selected.reference);
            formData.append('timestamp', timestamp);
            formData.append('option', 'report');
            formData.append('role', this.signRole());
            formData.append('page', this.currentPage);
            formData.append('total_pages', this.totalPages);
            formData.append('box_x0', pdfX);
            formData.append('box_y0', pdfY);
            formData.append('box_x1', pdfX + boxWidth);
            formData.append('box_y1', pdfY + boxHeight);

            this.$inertia.post('/signing', formData, {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: () => {
                    this.renderPdf(this.$page.props.flash.data);
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
        },
        toggleCollapse(id) {
            this.activeCollapse = this.activeCollapse === id ? null : id;
        },
        goToPage(page) {
            if (page < 1 || page > this.totalPages) return;

            this.showSignature = false;
            this.showSave = false;

            this.renderPdf(this.selected, this.index, page);
        }
    }
}
</script>
<style scoped>
.margin-custom {
    margin-bottom: -0.5px; margin-top: -2px;
}
.margin-space {
    margin-bottom: -3px;
}
</style>