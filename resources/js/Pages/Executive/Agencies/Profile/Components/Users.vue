<template>
    <div>
        <div class="d-flex mb-4">
            <div class="flex-grow-1">
                <div class="input-group mb-1">
                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                    <input type="text" v-model="filter.keyword" placeholder="Search Employee" class="form-control">
                    <Multiselect v-if="filter.role?.has_lab" class="white" style="width: 20%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :searchable="true" placeholder="Select Laboratory" />
                    <Multiselect
                    v-model="filter.role" :groups="true"
                    :options="dropdowns.roles"
                    label="name" object
                    style="width: 20%;"
                    ref="multiselect2"
                    placeholder="Select Role"/>
                    <Multiselect
                    v-model="filter.facility"
                    :options="facilities"
                    label="name"
                    style="width: 25%;"
                    ref="multiselect1"
                    placeholder="Select Facility"/>
                    <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                        <i class="bx bx-refresh search-icon"></i>
                    </span>
                    <b-button type="button" variant="danger" @click="openCreate">
                        <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                    </b-button>
                </div>
            </div>
        </div>
        <div class="table-responsive table-card" style="height: calc(100vh - 521px);">
            <simplebar data-simplebar style="height: calc(100vh - 476px);">
                <table class="table align-middle table-striped table-centered mb-0">
                    <thead class="table-light thead-fixed">
                        <tr class="fs-11">
                            <th style="width: 3%;"></th>
                            <th>Name</th>
                            <th style="width: 10%;" class="text-center">Username</th>
                            <th style="width: 10%;" class="text-center">Email</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                            <th style="width: 6%;"></th>
                        </tr>
                    </thead>
                    <tbody class="table-white fs-12" v-if="lists.length > 0">
                        <tr v-for="(list,index) in lists" v-bind:key="index" @click="selectRow(index)" :class="{
                            'bg-info-subtle': index === selectedRow,
                            'bg-danger-subtle': list.is_active === 0 && index !== selectedRow,
                            'bg-warning-subtle': list.is_active !== 0 && list.must_change && index !== selectedRow
                        }">
                            <td class="text-center">
                                <div class="avatar-xs chat-user-img online">
                                    <img :src="list.avatar" alt="" class="avatar-xs rounded-circle">
                                </div>
                            </td>
                            <td>
                                <h5 class="fs-13 mb-0 fw-semibold text-primary text-uppercase">{{list.name}}</h5>
                                <p class="fs-12 text-muted mb-0">
                                    <span class="badge bg-primary-subtle text-info me-1" v-for="role in list.roles" v-bind:key="role.id">{{ role.name }}</span>
                                </p>
                            </td>
                            <td class="text-center">{{ list.username }}</td>
                            <td class="text-center">{{ list.email }}</td>
                            <td class="text-center">
                                <span v-if="list.is_active" class="badge bg-success">Active</span>
                                <span v-else class="badge bg-danger">Inactive</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-3 justify-content-center">
                                    <button type="button" class="btn btn-ghost-primary btn-icon btn-sm material-shadow-none favourite-btn">
                                        <i class="ri-star-fill fs-13 align-bottom" :class="!list.is_active ? 'text-muted' : (list.must_change ? 'text-danger' : 'text-success')"></i>
                                    </button>
                                    <div class="dropdown">
                                        <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown" strategy="fixed" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }">
                                            <template #button-content>
                                                <i class="ri-more-fill"></i>
                                            </template>
                                            <li>
                                                <Link :href="`/users/${list.reference}`" class="dropdown-item d-flex align-items-center" role="button">
                                                    <i class="ri-eye-fill me-2"></i> View
                                                </Link>
                                            </li>
                                            <li>
                                                <a @click="openUpdate(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                    <i class="ri-edit-2-fill me-2"></i> Update
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a @click="openRole(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                    <i class="ri-group-2-line me-2"></i> Set Roles
                                                </a>
                                            </li>
                                            <li>
                                                <a @click="openActivation('verification',list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                    <i class="ri-mail-send-fill me-2"></i> Send Verification
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a @click="openActivation('activation',list,index)" class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" role="button">
                                                    <span v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i> Deactivate User</span>
                                                    <span v-else><i class="ri-lock-unlock-line me-2"></i> Activate User</span>
                                                </a>
                                            </li>
                                        </BDropdown>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No records found.</td>
                        </tr>
                    </tbody>
                </table>
            </simplebar>
        </div>
        <Pagination class="ms-2 me-2 mt-3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
        <Create :dropdowns="dropdowns" @update="fetch()" ref="create"/>
        <Role :dropdowns="dropdowns" ref="role"/>
        <Update @update="updateData" ref="update"/>
        <Activation @update="updateData" ref="activation"/>
    </div>
</template>
<script>
import _ from 'lodash';
import Role from '../../../Users/Modals/Role.vue';
import Create from '../../../Users/Modals/Create.vue';
import Update from '../../../Users/Modals/Update.vue';
import Activation from '../../../Users/Modals/Activation.vue';
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Multiselect, Activation, Update, Role, Create },
    props: ['agency', 'facilities', 'dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                laboratory: null,
                facility: null,
                role: null
            },
            index: null,
            selectedRow: null,
        }
    },
    created(){
       this.fetch();
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.laboratory"(newVal){
            this.fetch();
        },
        "filter.facility"(newVal){
            this.fetch();
        },
        "filter.role"(newVal){
            this.fetch();
        }
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/users';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    agency: this.agency?.value,
                    facility: this.filter.facility,
                    laboratory: this.filter.laboratory,
                    role: this.filter.role?.value,
                    count: 10,
                    option: 'list'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        refresh(){
            this.filter.keyword = null;
            this.filter.laboratory = null;
            this.filter.facility = null;
            this.filter.role = null;
            this.fetch();
        },
        openActivation(type,data,index){
            this.index = index;
            this.selectedRow = index;
            this.$refs.activation.show(type,data);
        },
        openUpdate(data,index){
            this.index = index;
            this.selectedRow = index;
            this.$refs.update.show(data);
        },
        openRole(data,index){
            this.index = index;
            this.selectedRow = index;
            this.$refs.role.show(data);
        },
        openCreate(){
            this.$refs.create.show(this.agency);
        },
        updateData(data){
            this.lists[this.index] = data;
        },
        selectRow(index) {
            if (this.selectedRow === index) {
                this.selectedRow = null;
            } else {
                this.selectedRow = index;
            }
        }
    }
}
</script>
