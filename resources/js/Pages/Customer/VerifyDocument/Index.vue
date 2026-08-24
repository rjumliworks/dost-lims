<template>
    <PageHeader title="Verify Document" pageTitle="Customer" />
    <b-row class="g-3">
        <b-col lg="12">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-shield-check-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Digital Signature Verification</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Upload a PDF to check whether it has been digitally signed, who signed it, and whether it has been altered since signing.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div v-if="!resultReady">
                        <file-pond name="pdf" ref="pond" allow-multiple="false" max-files="1" accepted-file-types="application/pdf"
                            label-idle='Drag &amp; Drop a PDF here or <span class="filepond--label-action">Browse</span>'
                            :allow-process="false" @addfile="handleAddFile"/>
                        <div class="text-muted fs-12 mt-2" v-if="checking"><span class="spinner-border spinner-border-sm me-1"></span>Checking document...</div>
                        <div class="text-danger fs-12 mt-2" v-if="errors">{{ errors }}</div>
                    </div>

                    <div v-else>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold fs-13">{{ fileName }}</div>
                            <b-button variant="light" size="sm" @click="reset"><i class="ri-refresh-line me-1"></i>Check another file</b-button>
                        </div>

                        <div v-if="!result.has_signatures" class="alert alert-warning d-flex align-items-center mb-0">
                            <i class="ri-error-warning-fill fs-20 me-2"></i>
                            <div>
                                <div class="fw-semibold">No digital signature found</div>
                                <div class="fs-12">This PDF does not contain any PNPKI digital signature. It may not have been signed through this system, or the signature was removed.</div>
                            </div>
                        </div>

                        <template v-else>
                            <div class="alert d-flex align-items-center mb-3" :class="result.all_intact ? 'alert-success' : 'alert-danger'">
                                <i class="fs-20 me-2" :class="result.all_intact ? 'ri-shield-check-fill' : 'ri-shield-cross-fill'"></i>
                                <div>
                                    <div class="fw-semibold">
                                        {{ result.all_intact ? 'Document is authentic — no tampering detected' : 'This document appears to have been altered after signing' }}
                                    </div>
                                    <div class="fs-12">
                                        {{ result.all_intact
                                            ? 'Every digital signature in this file still matches the content it was applied to.'
                                            : tamperReason }}
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fs-12">Signatory</th>
                                            <th class="fs-12">Signed On</th>
                                            <th class="fs-12">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(sig, index) in result.signatures" :key="index">
                                            <td class="fs-12">{{ sig.signer_name }}</td>
                                            <td class="fs-12">{{ formatDate(sig.signed_at) }}</td>
                                            <td class="fs-12">
                                                <span v-if="sig.intact" class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-fill align-bottom me-1"></i>Not tampered
                                                </span>
                                                <span v-else class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-close-circle-fill align-bottom me-1"></i>Tampered
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </b-col>
    </b-row>
</template>
<script>
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
const FilePond = vueFilePond(FilePondPluginFileValidateType);
import PageHeader from '@/Shared/Components/PageHeader.vue';

export default {
    components: { PageHeader, FilePond },
    data(){
        return {
            checking: false,
            errors: null,
            resultReady: false,
            result: null,
            fileName: '',
        }
    },
    computed: {
        tamperReason() {
            if (!this.result || this.result.all_intact) return '';

            const hasBrokenSignature = (this.result.signatures || []).some(sig => !sig.intact);
            if (hasBrokenSignature) {
                return 'Content that was already signed has been directly altered. Do not rely on this file.';
            }
            if (this.result.modified_after_signing) {
                return 'This file was edited (e.g. an annotation, comment, or other change) after signing was completed. Do not rely on this file.';
            }
            return 'This file no longer matches what was signed. Do not rely on this file.';
        },
    },
    methods: {
        handleAddFile(error, fileItem) {
            if (error) return console.error('FilePond error:', error);

            this.errors = null;
            this.checking = true;
            this.fileName = fileItem.file.name;

            const formData = new FormData();
            formData.append('pdf', fileItem.file, fileItem.file.name || 'document.pdf');

            this.$inertia.post('/verify-document', formData, {
                preserveScroll: true,
                preserveState: true,
                forceFormData: true,
                onSuccess: (page) => {
                    const flash = page.props.flash;

                    if (flash && flash.status !== false && flash.data) {
                        this.result = flash.data;
                        this.resultReady = true;
                    } else {
                        this.errors = (flash && flash.info) || 'Failed to check the document.';
                    }

                    this.checking = false;
                },
                onError: () => {
                    this.errors = 'Failed to check the document.';
                    this.checking = false;
                },
            });
        },
        formatDate(value) {
            if (!value) return '—';
            return new Date(value).toLocaleString();
        },
        reset() {
            this.resultReady = false;
            this.result = null;
            this.fileName = '';
            this.errors = null;
            if (this.$refs.pond) this.$refs.pond.removeFiles();
        },
    }
}
</script>
