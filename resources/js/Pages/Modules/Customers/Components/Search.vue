<template>
    <form class="app-search d-none d-md-block" style="margin-top: -14px;">
        <div class="position-relative">
            <!-- ✅ FIX: v-model added -->
            <input
                type="text"
                class="form-control"
                placeholder="Search..."
                autocomplete="off"
                id="search-options"
                v-model="keyword"
                style="background-color: white; border: 1PX solid #ced4da;"
            />

            <span class="mdi mdi-magnify search-widget-icon"></span>

            <span
                @click="clear"
                class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                id="search-close-options"
            ></span>
        </div>

        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
            <SimpleBar data-simplebar style="max-height: calc(100vh/2 - 326px)">
                <div class="notification-list">

                    <b-link
                        @click="chooseName(list)"
                        v-for="(list, index) of names"
                        :key="index"
                        class="d-flex dropdown-item notify-item py-2"
                    >
                        <div class="flex-1">
                            <h6 class="m-0">{{ list.name }}</h6>
                        </div>
                    </b-link>

                   <div class="d-flex flex-column align-items-center text-center mt-2 mb-2 border: 1px solid #e9ecef;" v-if="!showButton">
                        <span class="text-muted fs-12 mt-2">
                            Do you wish to add new customer name? we haven't found any duplicate
                        </span>

                        <b-button
                            @click="newCustomer()"
                            variant="primary"
                            class="mt-1"
                            size="sm"
                        >
                            New Customer name
                        </b-button>
                    </div>
                    <!-- <div class="d-flex">
                        <div class="flex-grow-1">
                            <span class="text-muted fs-12 mt-3 ms-3">
                                Do you wish to add new customer name? we haven't found any duplicate
                            </span>
                        </div>

                        <div class="flex-shrink-0">
                            <b-button
                                @click="newCustomer()"
                                variant="primary"
                                class="me-2"
                                size="sm"
                                block
                            >
                                New Customer name
                            </b-button>
                        </div>
                    </div> -->

                </div>
            </SimpleBar>
        </div>
    </form>
</template>

<script>
import _ from 'lodash';

export default {
    data() {
        return {
            currentUrl: window.location.origin,
            names: [],
            showButton: false,
            keyword: '' // ✅ IMPORTANT: not null
        };
    },

    mounted() {
        this.isCustomDropdown();
    },

    methods: {

        // ✅ debounce search
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 500),

        search() {
            axios.get('/customers', {
                params: {
                    keyword: this.keyword,
                    option: 'search'
                }
            })
            .then(response => {
                if (response.data.length > 0) {
                    this.names = response.data;
                    this.showButton = false;
                } else {
                    this.names = [];
                    this.showButton = true;
                }
            })
            .catch(err => console.log(err));
        },

        // ✅ FIXED: selecting updates input automatically via v-model
        chooseName(data) {
            this.keyword = data.name;   // 👈 updates input box
            this.names = [];            // clear dropdown
            this.showButton = true;

            this.$emit('set', data);
        },

        clear() {
            this.keyword = '';
            this.names = [];
            this.$emit('set', null);
        },

        newCustomer() {
            this.$emit('new', this.keyword);
        },

        set(name) {
            // ✅ THIS NOW WORKS because of v-model
            this.keyword = name;
            this.names = [];
            this.showButton = false;
        },

        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = this.keyword.length;

                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = this.keyword.length;

                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");

                    // ✅ FIXED: use Vue state, not DOM value
                    this.checkSearchStr(this.keyword);
                } else {
                    this.keyword = '';
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                this.keyword = '';
                this.names = [];
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
};
</script>

<style scoped>
.dropdown-menu-lg {
    width: 96.8%;
}
</style>