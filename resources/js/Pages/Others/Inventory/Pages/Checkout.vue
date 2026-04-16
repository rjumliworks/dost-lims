<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center align-items-center" style="background-color: #EFF0F3; min-height: 100vh;">

            <div class="row justify-content-center align-items-center">
                <div :class="(lists.length > 0) ? 'col-lg-9' : 'col-lg-12'">
                    <div class="text-center mb-5">
                        <h1 class="mb-3 ff-secondary fw-semibold text-capitalize lh-base" :class="(lists.length > 0) ? 'fs-22' : ''"><span class="text-primary">Inventory </span><span class="text-warning">Checkout </span> System</h1>
                        <p class="text-muted mb-4">Scan QR codes or search by item name to check out inventory items efficiently. <br/> Tracks borrower information, timestamps, and item status for accurate inventory management.</p>
                    </div>
                    <form action="#" class="job-panel-filter">
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
                    <ul class="treding-keywords list-inline mb-0 mt-3 fs-13" v-if="lists.length == 0">
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
                                                    <input type="number" @keydown="handleKeydown" v-maska data-maska="##" class="product-quantity" v-model="list.quantity" value="1" min="0" :max="list.onhand"/>
                                                </div>
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
                        <button @click="submit()" class="btn btn-primary flex-fill btn-lg fs-13" type="button">Checkout</button>
                    </div>

                </div>
            </div>
        </div>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>
</template>

<script>
import _ from 'lodash';
    export default {
        layout: null,
        data() {
            return {
                lists: [],
                carts: [],
                keyword: null
            };
        },
        mounted() {
            this.$refs.searchInput.focus();
        },
        watch: {
            "keyword"(newVal){
                if(newVal){ 
                    this.checkSearchStr(newVal);
                }
            }
        },
        methods: {
            checkSearchStr: _.debounce(function(string) {
                this.fetch();
            }, 300),
            fetch(page_url){
                page_url = page_url || '/inventory';
                axios.get(page_url,{
                    params : {
                        keyword: this.keyword,
                        option: 'checkout'
                    }
                })
                .then(response => {
                    if(response){
                        const newItem = response.data.data;
                        const exists = this.lists.some(item => item.id === newItem.id);
                        if (!exists) {
                            this.lists.unshift(newItem);
                        }
                        this.keyword = null;      
                    }
                })
                .catch(err => console.log(err));
            },
            topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            },
            removeItem(index){
                this.lists.splice(this.lists.indexOf(index), 1);
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
