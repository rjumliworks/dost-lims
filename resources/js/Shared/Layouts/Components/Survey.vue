<template>
    <b-modal body-class="p-0" header-class="p-0" hide-footer class="v-modal-custom" content-class="border-0 overflow-hidden" size="xl" centered no-close-on-backdrop hide-header-close>
        <BRow class="g-0">
            <BCol lg="9">
                <div class="modal-body p-5">
                    <h2 class="lh-base fw-semibold fs-22">
                        Welcome to <span class="text-primary">LIMS V3</span>! 🎉
                    </h2>

                    <p class="text-muted fs-13 mb-4">
                        Welcome to the new Laboratory Information Management System (LIMS V3).
                        This version introduces an improved user experience, streamlined workflows,
                        enhanced dashboards, and new features designed to support laboratory operations.
                    </p>

                    <div class="alert alert-info border-0 fs-12 mb-3">
                        <h6 class="fw-semibold mb-2">
                            <i class="ri-information-line me-1"></i> Important Information
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li>Dashboard statistics, reports, and displayed data are currently being reviewed and validated.</li>
                            <li>Some information may change as records are finalized and verified.</li>
                            <li>Data migration from the previous system is ongoing and will primarily be performed during weekends to minimize disruptions and ensure data integrity.</li>
                            <li>Additional enhancements and updates will continue to be released as part of the system improvement process.</li>
                        </ul>
                    </div>

                    <div class="alert alert-success border-0 fs-12 mb-4">
                        <h6 class="fw-semibold mb-2">
                            <i class="ri-lightbulb-line me-1"></i> Suggestions Are Welcome
                        </h6>
                        We encourage users to share suggestions, recommendations, and observations to help us improve LIMS V3. Your feedback is valuable in making the system more efficient, reliable, and user-friendly.
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-primary" @click="hide()">
                            Continue to LIMS V3
                        </button>
                    </div>
                </div>
            </BCol>

            <BCol lg="3">
                <div class="subscribe-modals-cover h-100">
                    <img src="images/auth-one-bg.jpg" alt=""
                    class="h-100 w-100 object-fit-cover"
                    style="clip-path: polygon(100% 0%, 100% 100%, 100% 100%, 0% 100%, 25% 50%, 0% 0%);">
                </div>
            </BCol>
        </BRow>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false
        }
    },

    methods: { 
        hide(){
            this.$emit('success',true);
        }
    }
}
</script>