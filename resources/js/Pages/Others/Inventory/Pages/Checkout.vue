<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center align-items-center" style="background-color: #EFF0F3; min-height: 100vh;">
          <div class="container">

            <div class="row justify-content-center align-items-center" v-if="step === 'search'">
                <div :class="(lists.length > 0) ? 'col-lg-9' : 'col-lg-12'">
                    <div class="text-center mb-5">
                        <h1 class="mb-3 ff-secondary fw-semibold text-capitalize lh-base" :class="(lists.length > 0) ? 'fs-22' : ''"><span class="text-primary">Inventory </span><span class="text-warning">Checkout </span> System</h1>
                        <p class="text-muted mb-4">Scan QR codes or search by item name to check out inventory items efficiently. <br/> Tracks borrower information, timestamps, and item status for accurate inventory management.</p>
                    </div>
                    <form action="#" class="job-panel-filter" @submit.prevent="fetch()">
                        <div class="row g-md-0 g-2">
                            <div class="col-md-9">
                                <div>
                                    <input type="search" v-model="keyword" ref="searchInput" id="job-title" class="form-control filter-input-box" placeholder="Search for name, suppplier or QR Code">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="h-100">
                                    <button class="btn btn-primary submit-btn w-100 h-100" type="submit"><i class="ri-search-2-line align-bottom me-1"></i> Find Item</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-danger mt-3 mb-0 fs-12 py-2" v-if="errorMessage">{{ errorMessage }}</div>
                    <div class="list-group shadow-sm mt-2" v-if="suggestions.length > 0">
                        <a href="javascript:void(0)" v-for="(item,i) in suggestions" v-bind:key="i" @click="selectSuggestion(item)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fs-13 fw-semibold text-uppercase text-primary">{{item.name}} {{item.unit}} {{item.type}} <span class="text-muted fw-normal text-lowercase">(S.N. / B.N. : {{item.number}})</span></h6>
                                <p class="mb-0 fs-11 text-muted">{{item.supplier}} &bull; Code: {{item.code}}</p>
                            </div>
                            <span class="badge bg-primary-subtle text-primary fs-11">On hand: {{item.onhand}}</span>
                        </a>
                    </div>
                    <ul class="treding-keywords list-inline mb-0 mt-3 fs-13" v-if="lists.length == 0 && suggestions.length == 0">
                        <li class="list-inline-item text-danger fw-semibold"><i class="mdi mdi-tag-multiple-outline align-middle"></i> Inventory Keywords:</li>
                        <li class="list-inline-item"><a href="javascript:void(0)">Chemical,</a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)">Media,</a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)">Supply</a></li>
                    </ul>
                </div>
                <div class="col-md-9 mt-4" v-if="lists.length > 0">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height: 2.5rem; width: 2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-shopping-cart-2-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Checkout Summary</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Review the items and details before completing the checkout.</p>
                                </div>
                                <div class="flex-shrink-0" style="width: 45%;"></div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="height: calc(-465px + 100vh); overflow: auto;">
                                <table class="table align-middle table-centered table-striped mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 3%;"></th>
                                            <th>Name</th>
                                            <th style="width: 15%;" class="text-center">Quantity</th>
                                            <th style="width: 5%;" class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-12">
                                        <tr class="" v-for="(list,index) in lists" v-bind:key="index">
                                            <td class="text-center">{{index+1}}.</td>
                                            <td>
                                                <h5 class="fs-12 mb-0 fw-semibold text-uppercase text-primary">{{list.name}} {{ list.unit }} {{ list.type }} <span class="text-muted fw-normal">(S.N. / B.N. : {{ list.number }})</span></h5>
                                                <p class="fs-12 text-muted mb-0">{{list.supplier}}</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-step">
                                                    <input type="number" @keydown="handleKeydown" v-maska data-maska="##" class="product-quantity" v-model="list.quantity" min="1" :max="list.onhand"/>
                                                </div>
                                                <p class="fs-10 text-muted mb-0 mt-1">On hand: {{ list.onhand }}</p>
                                            </td>
                                            <td class="text-center">
                                                <b-button @click="removeItem(index)" variant="light" v-b-tooltip.hover title="Remove" class="remove-list ms-1 me-n2">
                                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-n2">
                        <button @click="lists = []" class="btn btn-light flex-fill btn-lg fs-13" type="button">Cancel</button>
                        <button @click="openConfirm()" class="btn btn-primary flex-fill btn-lg fs-13" type="button">Checkout</button>
                    </div>

                </div>
            </div>

            <div class="row justify-content-center align-items-center" v-if="step === 'success'">
                <div class="col-lg-9">
                    <div class="card border-0 shadow-none mb-0">
                        <div class="card-body text-center pb-2">
                            <div class="avatar-sm mx-auto mb-2">
                                <div class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                                    <i class="ri-checkbox-circle-fill"></i>
                                </div>
                            </div>
                            <h5 class="text-success mb-0">Checkout Successful!</h5>
                            <p class="text-muted mb-4">{{ successInfo }}</p>
                        </div>
                    </div>
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <h5 class="mb-0 fs-14"><span class="text-body">Checkout Summary</span> <span class="text-muted fw-normal fs-12">({{ successAt }})</span></h5>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive">
                                <table class="table align-middle table-centered table-striped mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th style="width: 3%;"></th>
                                            <th>Name</th>
                                            <th class="text-center" style="width: 15%;">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-12">
                                        <tr v-for="(list,index) in checkedOutItems" v-bind:key="index">
                                            <td class="text-center">{{index+1}}.</td>
                                            <td>
                                                <h5 class="fs-12 mb-0 fw-semibold text-uppercase text-primary">{{list.name}} {{ list.unit }} {{ list.type }} <span class="text-muted fw-normal">(S.N. / B.N. : {{ list.number }})</span></h5>
                                                <p class="fs-12 text-muted mb-0">{{list.supplier}}</p>
                                            </td>
                                            <td class="text-center">{{list.quantity}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button @click="reset()" class="btn btn-primary btn-lg fs-13" type="button"><i class="ri-add-line align-bottom me-1"></i> Start New Checkout</button>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>

        <b-modal v-model="showConfirm" title="Confirm Checkout" centered no-close-on-backdrop hide-footer>
            <p class="text-muted fs-13">Please confirm you want to check out the following item(s):</p>
            <ul class="list-unstyled mb-3">
                <li v-for="(list,index) in lists" v-bind:key="index" class="d-flex justify-content-between border-bottom py-2 fs-13">
                    <span class="text-uppercase fw-semibold">{{ list.name }} {{ list.unit }} {{ list.type }}</span>
                    <span class="text-muted">Qty: {{ list.quantity }}</span>
                </li>
            </ul>
            <div class="d-flex gap-2">
                <button @click="showConfirm = false" class="btn btn-light flex-fill" type="button" :disabled="form.processing">Cancel</button>
                <button @click="submit()" class="btn btn-primary flex-fill" type="button" :disabled="form.processing">
                    <span v-if="form.processing"><span class="spinner-border spinner-border-sm me-1"></span> Processing...</span>
                    <span v-else>Confirm Checkout</span>
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
    export default {
        layout: null,
        data() {
            return {
                lists: [],
                keyword: null,
                suggestions: [],
                step: 'search',
                showConfirm: false,
                errorMessage: null,
                checkedOutItems: [],
                successInfo: null,
                successAt: null,
                form: useForm({
                    option: 'checkout',
                    items: []
                }),
            };
        },
        mounted() {
            this.$refs.searchInput.focus();
        },
        watch: {
            "keyword"(newVal){
                if(newVal){
                    this.checkSearchStr(newVal);
                }else{
                    this.suggestions = [];
                }
            }
        },
        methods: {
            checkSearchStr: _.debounce(function(string) {
                this.fetch();
            }, 300),
            fetch(page_url){
                page_url = page_url || '/inventory';
                const keyword = this.keyword;
                axios.get(page_url,{
                    params : {
                        keyword: keyword,
                        option: 'checkout'
                    }
                })
                .then(response => {
                    const results = (response && response.data && response.data.data) || [];
                    if(this.keyword !== keyword){
                        return;
                    }
                    if(results.length === 0){
                        this.suggestions = [];
                        this.errorMessage = 'No matching item found for "' + keyword + '".';
                        return;
                    }
                    const exactCode = results.find(item => item.code === keyword);
                    if(results.length === 1 || exactCode){
                        this.addToCart(exactCode || results[0]);
                        return;
                    }
                    this.errorMessage = null;
                    this.suggestions = results;
                })
                .catch(err => console.log(err));
            },
            addToCart(item){
                if(!item.onhand || item.onhand <= 0){
                    this.errorMessage = `${item.name} has no available stock on hand.`;
                }else{
                    this.errorMessage = null;
                    const exists = this.lists.some(list => list.id === item.id);
                    if (!exists) {
                        this.lists.unshift({ ...item, quantity: 1 });
                    }
                }
                this.suggestions = [];
                this.keyword = null;
            },
            selectSuggestion(item){
                this.addToCart(item);
                this.$refs.searchInput.focus();
            },
            topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            },
            removeItem(index){
                this.lists.splice(index, 1);
            },
            openConfirm(){
                this.errorMessage = null;
                const invalid = this.lists.some(list => {
                    const quantity = parseInt(list.quantity);
                    return !quantity || quantity < 1 || quantity > list.onhand;
                });
                if(invalid){
                    this.errorMessage = 'Please enter a valid quantity (at least 1, and not exceeding the on hand amount) for each item.';
                    return;
                }
                this.showConfirm = true;
            },
            submit(){
                this.form.items = this.lists.map(list => ({ id: list.id, quantity: parseInt(list.quantity) }));
                this.form.post('/inventory', {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: (page) => {
                        this.showConfirm = false;
                        const flash = page.props.flash;
                        if(flash && flash.status){
                            this.checkedOutItems = this.lists.map(list => ({ ...list }));
                            this.successInfo = flash.info || "You've successfully checked out the selected items.";
                            this.successAt = new Date().toLocaleString();
                            this.lists = [];
                            this.step = 'success';
                        }else{
                            this.errorMessage = (flash && (flash.info || flash.message)) || 'Checkout failed. Please try again.';
                        }
                    },
                    onError: () => {
                        this.showConfirm = false;
                        this.errorMessage = 'Please check the quantities entered and try again.';
                    }
                });
            },
            reset(){
                this.step = 'search';
                this.errorMessage = null;
                this.suggestions = [];
                this.checkedOutItems = [];
                this.$nextTick(() => {
                    if(this.$refs.searchInput){
                        this.$refs.searchInput.focus();
                    }
                });
            },
        }
    };

</script>
<style scoped>
    .auth-page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .auth-page-content {
        flex: 1 0 auto;
    }
</style>
