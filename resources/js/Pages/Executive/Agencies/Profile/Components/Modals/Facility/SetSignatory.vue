<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Assign Signatory" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="p-3">
                <BCol lg="12">
                    <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12" role="alert">
                        <i class="ri-alert-line label-icon"></i>
                        <strong>Notice:</strong>
                        This action will assign an <strong>{{ form.type }}</strong>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-4">
                    <form class="app-search d-none d-md-block mb-n3" style="margin-top: -33px;">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search Employee" autocomplete="off" id="search-options" />
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span @click="clear()" class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <SimpleBar data-simplebar >
                                <div class="notification-list">
                                    <b-link @click="chooseUser(list)" v-for="(list, index) of names" :key="index" class="d-flex dropdown-item notify-item py-2">
                                        <img :src="list.avatar" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                        <div class="flex-1">
                                            <h6 class="m-0">{{ list.name}}</h6>
                                            <span class="fs-11 mb-0 text-muted">{{list.role}}</span>
                                        </div>
                                    </b-link>
                                </div>
                            </SimpleBar>
                        </div>
                    </form>
                </BCol>
                <BCol lg="12" class="mt-n1 mb-n2" v-if="user">
                    <hr class="text-muted"/>
                </BCol>
                <BCol md v-if="user">
                    <BRow class="align-items-center g-1">
                        <BCol md="auto">
                            <div style="height: 3.5rem; width: 3.5rem;">
                                <div class="avatar-title bg-white rounded-circle">
                                    <img :src="user.avatar" alt="" class="avatar-sm rounded-circle">
                                </div>
                            </div>
                        </BCol>
                        <BCol md>
                            <div class="ms-2">
                                <h4 class="fs-16 text-uppercase text-primary fw-semibold mb-0 mt-1">{{ user.name }}</h4>
                                <div class="hstack gap-3 flex-wrap">
                                    <div class="text-muted">{{user.role}}</div>
                                </div>
                            </div>
                        </BCol>
                    </BRow>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
export default {  
    data(){
        return {
            form: useForm({
                id: null,
                user_id: null,
                agency: null,
                type: null,
                option: 'signatory'
            }),
            keyword: null,
            names: [],
            user: null,
            selected: null,
            showModal: false
        }
    },
    mounted() {
        this.isCustomDropdown();
    },
    methods: { 
        show(id,type,agency){
            this.form.reset();
            this.names = [];
            this.user = null;
            this.form.id = id;
            this.form.agency = agency;
            this.form.type = type;
            this.showModal = true;
        },
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 500),
        search(){
            axios.get('/search', {
                params: {
                    keyword: this.keyword,
                    agency: this.form.agency,
                    option: 'users'
                }
            })
            .then(response => {
                if(response){ 
                    this.names = response.data; 
                }
            })
            .catch(err => console.log(err));
        },
        chooseUser(data){
            this.user = data;
            this.form.user_id = data.value;
            this.keyword = null;
            document.getElementById("search-options").value = "";
            document.getElementById("search-options").focus();
        }, 
        submit(){
            this.form.post('/agencies',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.reset();
                    this.$emit('update',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        clear(){
            this.user = null;
            this.names = [];
        },  
        hide(){
            this.editable = false;
            this.showModal = false;
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }
}
</script>
<style scoped>
    .dropdown-menu-lg {
        width: 95%;
    }
</style>