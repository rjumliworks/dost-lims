<template>
<div class="card bg-light-subtle shadow-none border">
    <div class="card-header bg-light-subtle">
        <div class="d-flex mb-n3">
            <div class="flex-shrink-0 me-3">
                <div style="height:2.5rem;width:2.5rem;">
                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                        <i class="ri-apps-2-fill text-primary fs-24"></i>
                    </span>
                </div>
            </div>
            <div class="flex-grow-1">
                <h5 class="mb-0 fs-14"><span class="text-body">{{ isAnalyst ? 'Analyst Performance Summary' : 'Overview' }}</span></h5>
                <p class="text-muted text-truncate-two-lines fs-12">{{ isAnalyst ? 'Monthly test performance, useful for IPCR reporting.' : "This is your personal hub where you can manage your account details, preferences, and interactions within our platform." }}</p>
            </div>
        </div>
    </div>
    <div class="card-body bg-white rounded-bottom" style="height: calc(100vh - 297px); overflow: auto;">
        <Performance v-if="isAnalyst" :laboratories="laboratories"/>
    </div>
</div>
</template>
<script>
import Performance from './Components/Performance.vue';
export default {
    components: { Performance },
    props: ['laboratories'],
    computed: {
        isAnalyst() {
            return this.$page.props.roles.includes('Laboratory Analyst') || this.$page.props.roles.includes('Calibration Officer');
        }
    }
}
</script>
