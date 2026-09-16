<template>
    <div class="d-flex" style="height: calc(100vh - 470px);">
        <div style="width: 34%;" class="border-end pe-2">
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Employee" class="form-control">
            </div>
            <simplebar data-simplebar style="height: calc(100vh - 530px);">
                <ul class="list-unstyled mb-0">
                    <li v-for="(user, index) in users" v-bind:key="index"
                        class="p-2 border-bottom fs-12" style="cursor: pointer;"
                        :class="{ 'bg-info-subtle': selectedUser?.reference === user.reference }"
                        @click="selectUser(user)">
                        <h6 class="mb-0 fs-12 text-uppercase">{{ user.name }}</h6>
                        <span class="badge bg-primary-subtle text-info me-1 fs-10" v-for="role in user.roles" v-bind:key="role.id">{{ role.name }}</span>
                    </li>
                </ul>
                <div v-if="users.length === 0" class="text-center text-muted py-4 fs-12">No users found.</div>
            </simplebar>
        </div>
        <div style="width: 66%;" class="ps-3">
            <div v-if="!selectedUser" class="text-center text-muted py-5 fs-12">
                Select a user to manage which facilities' TSRs they're allowed to view.
            </div>
            <template v-else>
                <div class="d-flex mb-2 align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fs-13 text-uppercase">{{ selectedUser.name }}</h6>
                        <span class="badge fs-10" :class="isCustomized ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary'">
                            {{ isCustomized ? 'Customized' : 'Default' }}
                        </span>
                    </div>
                    <div class="flex-shrink-0" v-if="isCustomized">
                        <button type="button" class="btn btn-sm btn-soft-secondary" :disabled="saving" @click="reset">
                            <i class="ri-refresh-line align-bottom"></i> Reset to Default
                        </button>
                    </div>
                </div>
                <p class="text-muted fs-12">By default a user only sees TSRs from their own facility, unless they're stationed at a regional facility and hold the Customer Relation Officer or Laboratory Head role. Use the toggles below to adjust exactly which facilities this user can view.</p>
                <div v-if="loading" class="text-center text-muted py-4 fs-12">Loading...</div>
                <table v-else class="table table-nowrap align-middle mb-0">
                    <thead class="bg-primary text-white thead-fixed">
                        <tr class="fs-10">
                            <th>Facility</th>
                            <th style="width: 18%;" class="text-center">Regional</th>
                            <th style="width: 15%;" class="text-center">Visible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="facility in facilities" v-bind:key="facility.id" class="fs-12">
                            <td>{{ facility.name }}</td>
                            <td class="text-center">
                                <span v-if="facility.is_regional" class="badge bg-info-subtle text-info">Regional</span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch form-switch-md d-flex justify-content-center mb-0">
                                    <input type="checkbox" class="form-check-input" role="switch"
                                        :checked="visible.includes(facility.id)" :disabled="saving"
                                        @change="toggle(facility.id, $event.target.checked)">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
        </div>
    </div>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import simplebar from 'simplebar-vue';
export default {
    components: { simplebar },
    props: ['agency', 'facilities'],
    data() {
        return {
            users: [],
            filter: { keyword: null },
            selectedUser: null,
            visible: [],
            isCustomized: false,
            loading: false,
            saving: false,
            form: useForm({
                user: null,
                facility_ids: [],
                option: 'visibility'
            }),
            resetForm: useForm({
                user: null,
                option: 'reset_visibility'
            }),
        }
    },
    created() {
        this.fetchUsers();
    },
    watch: {
        "filter.keyword"() {
            this.checkSearchStr();
        }
    },
    methods: {
        checkSearchStr: _.debounce(function () {
            this.fetchUsers();
        }, 300),
        fetchUsers() {
            axios.get('/users', {
                params: {
                    keyword: this.filter.keyword,
                    agency: this.agency?.value,
                    count: 100,
                    option: 'list'
                }
            }).then(response => {
                this.users = response.data.data;
            }).catch(err => console.log(err));
        },
        selectUser(user) {
            this.selectedUser = user;
            this.fetchVisibility();
        },
        fetchVisibility() {
            this.loading = true;
            axios.get('/agencies', {
                params: { option: 'visibility', user: this.selectedUser.reference }
            }).then(response => {
                this.visible = response.data.facility_ids || [];
                this.isCustomized = response.data.is_customized;
            }).catch(err => console.log(err))
            .finally(() => { this.loading = false; });
        },
        toggle(facilityId, checked) {
            if (checked) {
                if (!this.visible.includes(facilityId)) this.visible.push(facilityId);
            } else {
                this.visible = this.visible.filter(id => id !== facilityId);
            }
            this.save();
        },
        save() {
            this.saving = true;
            this.form.user = this.selectedUser.reference;
            this.form.facility_ids = this.visible;
            this.form.post('/agencies', {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => { this.isCustomized = true; },
                onFinish: () => { this.saving = false; }
            });
        },
        reset() {
            this.saving = true;
            this.resetForm.user = this.selectedUser.reference;
            this.resetForm.post('/agencies', {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => { this.fetchVisibility(); },
                onFinish: () => { this.saving = false; }
            });
        }
    }
}
</script>
