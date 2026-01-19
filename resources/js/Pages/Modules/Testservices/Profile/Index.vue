<template lang="">
    <Head title="Customer Profile"/>
    <Top :service="service"/>
    <b-row class="g-3">
        <Sidebar :service="service"/>
        <b-col lg="8">
            <b-row>
                <b-col lg="12 ">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem;width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-file-text-line text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Add-ons for this Service</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Displays optional add-ons and their corresponding fees.</p>
                                </div>
                                <template v-if="type == 'Add-ons'">
                                    <div v-if="service.data.status.name == 'Approved' || service.data.status.name == 'Pending'" class="flex-shrink-0">
                                        <BButton @click="openFee()" variant="danger" class="btn-sm waves-effect waves-light mt-1">
                                            Add Fee
                                        </BButton>
                                    </div>
                                </template>
                                <template v-if="type == 'Sampletype'">
                                    <div v-if="service.data.status.name == 'Approved' || service.data.status.name == 'Pending'" class="flex-shrink-0">
                                        <BButton @click="openTag()" variant="danger" class="btn-sm waves-effect waves-light mt-1">
                                            Add Sampletype
                                        </BButton>
                                    </div>
                                </template>
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
                        <div class="card-body bg-white rounded-bottom">
                            <div class="tab-content">
                                <div class="tab-pane" :class="(index == 0) ? 'show active' : ''" :id="menu" role="tabpanel" :aria-labelledby="menu+'-tab'" v-for="(menu, index) in menus" v-bind:key="index">
                                    
                                    <div class="carousel-container">
                                        <div class="carousel-content">
                                            <transition mode="out-in">
                                                <div :key="index" class="tab-content">
                                                    <Sampletype :samples="service.data.samples" v-if="menu == 'Sampletype'"/>
                                                    <List :fees="service.data.fees" @edit-fee="editFee" v-if="menu == 'Add-ons'"/>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
    <Fee ref="fee"/>
    <Sample ref="sample"/>
</template>
<script>
import Top from './Top.vue';
import Fee from '../Modals/Fee.vue';
import Sample from './Modals/Sample.vue';
import List from './Components/List.vue';
import Sampletype from './Components/Sampletype.vue';
import Sidebar from './Sidebar.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props:['service'],
    components: { PageHeader, Top, Sidebar, List, Fee, Sampletype, Sample },
    data(){
        return {
            menus: [
                'Sampletype','Add-ons','Logs'
            ],
            type: 'Sampletype',
            index: null,
        }
    },
    methods: {
        openFee(){
            this.$refs.fee.show(this.service.data.id);
        },
        editFee(data){
            this.$refs.fee.edit(data);
        },
        openTag(){
            this.$refs.sample.show(this.service.data.id,this.service.data.laboratory.id);
        }
    }
}
</script>