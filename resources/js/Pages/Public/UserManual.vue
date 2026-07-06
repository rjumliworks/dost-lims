<template>
    <div id="layout-wrapper" class="auth-page-wrapper pt-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content">
            <BContainer>

                <BRow class="justify-content-center">
                    <BCol lg="12">
                        <div class="card bg-light-subtle shadow-none border">
                            <div class="card-header bg-primary">
                                <div class="d-flex mb-n2">
                                    <div class="flex-shrink-0 me-3">
                                        <div style="height:2.5rem;width:2.5rem;">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                        </div>
                                    </div>
                                     <div class="flex-grow-1">
                                        <h5 class="mb-0 mt-2 fs-14 fw-semibold text-uppercase text-white" style="font-size: 10.7px">DEPARTMENT OF SCIENCE AND TECHNOLOGY</h5>
                                        <p class="text-white fs-11"><span class="fw-semibold">One<span class="text-info">DOST</span>4U</span> : <span class="text-muted">Laboratory Information Management System</span></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="mb-0 mt-2 fs-24 me-3 fw-semibold text-uppercase text-white">USER MANUAL 1.0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="car-body bg-white shadow-none" style="height: calc(100vh - 250px); overflow-y: auto; overflow-x:hidden;">
                                
                                <div v-if="showList" class="card-body">
                                    <p class="text-muted">Use <code>list-group-numbered</code> class (optionally use an <code>&lt;ol&gt;</code> element) to show numbered list group items. </p>
                                    <div class="live-preview">
                                        <ol class="list-group list-group-numbered">

                                            <li
                                                class="list-group-item list-group-item-action"
                                                @click="openGuide('user')">
                                                Account Activation and First-Time Login Guide
                                            </li>

                                            <li
                                                class="list-group-item list-group-item-action"
                                                @click="openGuide('categories')">
                                                Categories Module Guide
                                            </li>

                                            <li
                                                class="list-group-item list-group-item-action"
                                                @click="openGuide('testservice')">
                                                Test Services Module Guide
                                            </li>

                                            <li
                                                class="list-group-item list-group-item-action"
                                                @click="openGuide('packages')">
                                                Packages Module Guide
                                            </li>

                                        </ol>
                                    </div>
                                </div>
                                  
                            <div v-else>
                                <button
                                    class="btn btn-light mb-3"
                                    @click="backToList">
                                    <i class="ri-arrow-left-line me-1"></i>
                                    Back to User Manual
                                </button>
                                <User v-if="selectedGuide === 'user'" />
                                <Categories v-else-if="selectedGuide === 'categories'" />
                                <Testservice v-else-if="selectedGuide === 'testservice'" />
                                <Packages v-else-if="selectedGuide === 'packages'" />
                            </div>




                            </div>
                            <div class="card-footer bg-light-subtle mb-n4">
                                 <div class="text-center p-1">
                                    <p class="mb-0 fs-11 text-muted">Thank you for helping us maintain a secure and reliable system.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </BCol>
                </BRow>
            </BContainer>
        </div>
    </div>
</template>
<script>
import User from './Documentation/User.vue';
import Packages from './Documentation/Packages.vue';
import Categories from './Documentation/Categories.vue';
import Testservice from './Documentation/Testservice.vue';
export default {
    components: { User, Packages, Categories, Testservice },
    layout: null,
    data(){
        return {
            showList: true,
            selectedGuide: null
        }
    },
    methods: {
        openGuide(guide) {
            this.selectedGuide = guide;
            this.showList = false;
        },
        backToList() {
            this.selectedGuide = null;
            this.showList = true;
        }
}
}
</script>