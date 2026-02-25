<template>
    <Head title="Date Time Record"/>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content">
            <BContainer style="width: 1000px;">

                <BRow class="justify-content-center">
                    <div class="col-lg-12">
                  
                        <div class="card border bg-white">
                            <div class="card-header bg-primary">
                                <div class="d-flex mb-n2">
                                    <div class="flex-shrink-0 me-3">
                                        <div style="height:2.5rem;width:2.5rem;">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                         <h5 class="mb-0 mt-2 fs-14 fw-semibold text-uppercase text-white" style="font-size: 10.7px"> CUSTOMER PORTAL</h5>
                                        <p class="text-white fs-11"><span class="fw-semibold">DOST-IX One<span class="text-info">DOST</span>4U</span></p>
                                    </div>
                                    <div class="flex-shrink-0 ms-auto text-end">
                                     <button @click="logout" class="btn btn-light btn-sm" style="margin-top: 10px;">Logout</button>
                                    </div>
                                </div>
                            </div>
                             <div class="card bg-white rounded-bottom shadow-none mb-0">
                                <div class="step-arrow-nav mt-0">
                                    <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                        <li class="nav-item" role="presentation" v-for="(menu, index) in menus" v-bind:key="index">
                                            <button @click="type = menu" class="nav-link fs-12 p-3" :class="(index == 0) ? 'active' : ''" 
                                                :id="menu+'-tab'" data-bs-toggle="pill" :data-bs-target="'#'+menu" 
                                                type="button" role="tab" :aria-controls="menu" aria-selected="true">
                                                {{menu}}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="height: 500px;">
                                <div class="row g-3 mb-n3">
                                    <div class="tab-content">
                                        <div class="tab-pane" :class="(index == 0) ? 'show active' : ''" :id="menu" role="tabpanel" :aria-labelledby="menu+'-tab'" v-for="(menu, index) in menus" v-bind:key="index">
                                            
                                            <div class="carousel-container">
                                                <div class="carousel-content">
                                                    <transition mode="out-in">
                                                        <div :key="index" class="tab-content">
                                                            <Lists :id="viewer.id" v-if="menu == 'TSRs'"/>
                                                            <Conforme :lists="customer.conformes" v-if="menu == 'Conformes'"/>
                                                            <Payor :lists="customer.payors" v-if="menu == 'Payors'"/>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>

                                            <!-- {{ viewer }} -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </BRow>

            </BContainer>
        </div>
    </div>
    
</template>
<script>
import Logs from './Components/Logs.vue';
import Lists from './Components/Lists.vue';
import Payor from './Components/Payor.vue';
import Conforme from './Components/Conforme.vue';
export default {
    layout: null,
    components: {Lists, Conforme, Payor, Logs },
    data() {
        return {
            viewer: this.$page.props.viewer,
            currentUrl: window.location.origin,
            customer: {conformes: [], payors: []},
            menus: [
                'TSRs','Conformes','Payors'
            ],
            type: null,
            index: null,
        };
    },
    created(){
        this.fetch();
    },
    methods: {
        async logout() {
            try {
                await axios.get('/customer/logout')
                window.location.href = '/customer/login' // redirect manually after logout
            } catch (error) {
                console.error('Logout failed:', error)
            }
        },
        fetch(page_url) {
            page_url = page_url || '/customer/profile';
            axios.get(page_url,{
                params : {
                    id: this.viewer.id
                }
            })
            .then(response => {
                if(response){
                    this.customer = response.data.data;
                }
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
<style>
.table-responsive {
    min-height: 200px;
}
</style>