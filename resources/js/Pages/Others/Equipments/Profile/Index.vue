<template lang="">
    <Head title="Equipment Profile"/>
    <Top :equipment="equipment"/>
    <b-row class="g-3">
        <Sidebar :equipment="equipment.data"/>
        <b-col lg="9">
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
                                    <h5 class="mb-0 fs-14"><span class="text-body">Item Transaction Logs</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">A comprehensive list of all TSRs (Test Service Requests) and Conformes, including their statuses and associated details.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-white rounded-bottom shadow-none mb-0">
                            <div class="step-arrow-nav mt-0">
                                <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                    <li class="nav-item" role="presentation" v-for="(menu, index) in menus" v-bind:key="index">
                                        <button @click="type = menu.key" class="nav-link fs-12 p-3" :class="(index == 0) ? 'active' : ''" 
                                            :id="menu.key+'-tab'" data-bs-toggle="pill" :data-bs-target="'#'+menu.key" 
                                            type="button" role="tab" :aria-controls="menu.key" aria-selected="true">
                                            {{menu.label}}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card">
                                <simplebar data-simplebar style="max-height: 200px;">
                                    <table class="table table-bordered table-nowrap align-middle mb-0">
                                        <thead class="table-primary thead-fixed">
                                            <tr class="fs-11">
                                                <th colspan="5" class="text-center text-primary">Calibration / Maintance Logs</th>
                                            </tr>
                                        </thead>
                                        <thead class="table-light thead-fixed">
                                            <tr class="fs-11">
                                                <th style="width: 15%;" class="text-center">Type</th>
                                                <th style="width: 15%;" class="text-center">Date</th>
                                                <th style="width: 30%;" class="text-center">User</th>
                                                <th style="width: 40%;" class="text-center">Note</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fs-11" v-for="(list,index) in equipment.data.logs" v-bind:key="index">
                                                <td class="text-center">
                                                    <span v-if="list.is_calibrated == 1" class="badge bg-success">Calibration</span>
                                                    <span v-else class="badge bg-danger">Maintenance</span>
                                                </td>
                                                <td class="text-center">{{ list.date }}</td>
                                                <td class="text-center">{{ list.name }}</td>
                                                <td class="text-center">{{ (list.note) ? list.note : 'n/a' }}</td>
                                                <td>
                                                    <b-button  @click="openEdit(list,index)" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                                        <i class="ri-delete-bin-fill align-bottom"></i>
                                                    </b-button>
                                                </td>
                                            </tr>
                                            <tr v-if="equipment.data.logs.length == 0">
                                                <td colspan="4" class="text-center text-muted fs-10">
                                                    No records found. There are no logs available for the calibration or maintenance of the equipment.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </simplebar>
                            </div>
                            <!-- <div class="tab-content">
                                <div class="tab-pane" :class="(index == 0) ? 'show active' : ''" :id="menu.key" role="tabpanel" :aria-labelledby="menu.key+'-tab'" v-for="(menu, index) in menus" v-bind:key="index">
                                    
                                    <div class="carousel-container">
                                        <div class="carousel-content">
                                            <transition mode="out-in">
                                                <div :key="index" class="tab-content">
                                                   {{equipment}}
                                                </div>
                                            </transition>
                                        </div>
                                    </div>

                                </div>
                            </div> -->
                        </div>
                        
                    </div>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</template>
<script>
import Top from './Top.vue';
import simplebar from 'simplebar-vue';
import Sidebar from './Sidebar.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props:['equipment'],
    components: { PageHeader, Top, Sidebar, simplebar },
    data(){
        return {
            menus: [
                { label: 'Maintenance', key: 'maintenance' },
                { label: 'Calibration', key: 'calibration' }
            ],
            type: 'maintenance',
            index: null,
        }
    }
}
</script>