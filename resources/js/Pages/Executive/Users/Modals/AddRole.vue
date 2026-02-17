
<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Role" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-n1">
                <BCol lg="12" class="mt-0 mb-2">
                    <div class="alert fs-10 alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0 material-shadow" role="alert">
                        <i class="ri-error-warning-line label-icon"></i><strong>Notice</strong>
                        - Adding a new role will grant the user access to the corresponding role module.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0 mb-2">
                    <InputLabel value="Role" :message="form.errors.role_id"/>
                     <Multiselect
                    v-model="form.role" :groups="true"
                    :options="filteredRoles"
                    label="name"
                    object
                    ref="multiselect2"
                    placeholder="Select Role"/>
                </BCol>
                
                 <BCol lg="12" v-if="has_lab" class="mt-0">
                    <InputLabel for="laboratory_id" value="Laboratory" :message="form.errors.laboratory_id"/>
                    <Multiselect :options="filteredLaboratories" label="name" v-model="form.laboratory_id" placeholder="Select Laboratory" ref="multiselect3"/>
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
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { Multiselect, InputLabel },
    props: ['dropdowns'],
    data(){
        return {
            form: useForm({
                code: null,
                role: null,
                role_id: null,
                laboratory_id: null,
                type: 'add',
                option: 'role'
            }),
            user: {},
            type: null,
            has_lab: false,
            showModal: false,
        }
    },
    computed: {
        filteredRoles() {
            if (!this.dropdowns.roles || !this.user?.roles) {
                return this.dropdowns.roles || [];
            }

            return this.dropdowns.roles
                .map(group => {

                    const filteredOptions = group.options.filter(role => {

                        // find if user already has this role active
                        const existingRole = this.user.roles.find(
                            r => r.name === role.name && r.is_active === 1
                        );

                        if (!existingRole) {
                            // user doesn't have it → allow
                            return true;
                        }

                        // user has it
                        // allow if role supports lab assignment
                        if (role.has_lab === 1) {
                            return true;
                        }

                        // otherwise hide it
                        return false;
                    });

                    if (filteredOptions.length === 0) return null;

                    return {
                        label: group.label,
                        options: filteredOptions
                    };
                })
                .filter(Boolean);
        },
        filteredLaboratories() {
            if (!this.has_lab || !this.form.role || !this.user?.roles) {
                return this.dropdowns.laboratories || [];
            }
            const selectedRoleId = this.form.role.value;
            console.log(selectedRoleId);
            const assignedLabIds = this.user.roles
                .filter(r => 
                    r.role_id === selectedRoleId &&
                    r.is_active === 1 &&
                    r.laboratory !== null
                )
                .map(r => r.laboratory_id);
                console.log(this.user.roles);
            return this.dropdowns.laboratories.filter(
                lab => !assignedLabIds.includes(lab.value)
            );
        }
    },
    watch: { 
        "form.role"(newVal){
            if(newVal){
                if(newVal.has_lab){
                    this.has_lab = 1
                }else{
                    this.has_lab = 0
                }
                this.form.role_id = newVal.value;
            }else{
                this.has_lab = 0;
                this.form.laboratory_id = null;
                this.form.role_id = null;
            }
        },
    },
    methods: { 
        show(data){
            this.user = data;
            this.form.code = this.user.code,
            this.showModal = true;
        },
        submit(){
            this.form.put('/users/update', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.user = {};
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>