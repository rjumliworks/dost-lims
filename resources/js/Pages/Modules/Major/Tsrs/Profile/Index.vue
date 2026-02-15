<template lang="">

    <Head :title="(tsr.data.code) ? tsr.data.code : tsr.data.customer.name" />
    <div v-if="tsr.data.status?.name === 'Cancelled'" class="overlay-cancelled">
        <div class="overlay-text">TS REQUEST IS CANCELLED</div>
    </div>
    <div class="auth-page-wrapper d-flex min-vh-100">
        <div :class="{ 'cancelled-wrapper': tsr.data.status?.name === 'Cancelled' }" class="auth-page-content">
            <Top :selected="tsr.data" :analyses="analyses.data.length" :dropdowns="dropdowns"/>
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <div class="file-manager-content w-100 p-4 pb-0" ref="box" style="margin-left: 20px;">
                    <Main :selected="tsr.data" :services="dropdowns.services" :analyses="analyses.data" />
                </div>
                <div class="file-manager-sidebar" style="margin-right: 20px;">
                    <simplebar data-simplebar style="overflow-x: hidden;" class="h-100" ref="scrollbar">
                        <Sidebar :selected="tsr.data" :services="dropdowns.services" :total="totalFee"/>
                    </simplebar>
                </div>

            </div>
        </div>
    </div>
    <Message ref="message" />
</template>
<script>
import Top from './Components/Top.vue';
import Main from './Components/Main.vue';
import Sidebar from './Components/Sidebar.vue';
import Message from './Modals/Message.vue';
import simplebar from "simplebar-vue";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    layout: null,
    components: {
        PageHeader,
        simplebar,
        Top,
        Sidebar,
        Message,
        Main
    },
    props: ['tsr','analyses','dropdowns'],
    computed: {
        totalFee() {
            if (!this.analyses.data || typeof this.analyses.data !== 'object') return 0;

            return Object.values(this.analyses.data).reduce((sum, a) => {
                const mainFee = Number(String(a.fee || 0).replace(/[₱,]/g, ''));
                let addFeeTotal = 0;
                if (Array.isArray(a.addfee) && a.addfee.length > 0) {
                    addFeeTotal = a.addfee.reduce((subSum, f) => {
                        const feeTotal = Number(String(f.total || 0).replace(/[₱,]/g, ''));
                        return subSum + feeTotal;
                    }, 0);
                }
                return sum + mainFee + addFeeTotal;
            }, 0);
        }
    },
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
        min-width: 24%;
        max-width: 24%;
        height: calc(100vh - 92px);
    }

    .overlay-cancelled {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        /* dark transparent background */
        box-sizing: border-box;
        z-index: 9999;
        pointer-events: none;
    }

    .overlay-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-10deg);
        /* tilt the text */
        color: red;
        font-size: 3rem;
        font-weight: 600;
        border: 8px solid red;
        padding: 0.5rem 2.5rem;
        border-radius: 15px;

        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .cancelled-wrapper {
        pointer-events: none;
    }

</style>
