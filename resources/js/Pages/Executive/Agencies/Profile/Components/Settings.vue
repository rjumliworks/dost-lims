<template>
    <div>
        <div class="step-arrow-nav mt-0 mb-3">
            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                <li class="nav-item" role="presentation" v-for="(tab, index) in tabs" v-bind:key="index">
                    <button @click="active = tab" class="nav-link fs-12 p-2" :class="(active === tab) ? 'active' : ''" type="button" role="tab">
                        {{ tab }}
                    </button>
                </li>
            </ul>
        </div>
        <FormSettings :selected="selected" v-if="active === 'Form Settings'"/>
        <AddressSettings :id="selected.data.configuration?.id" :values="selected.data.configuration?.printing?.address_format" :options="addressComponents" v-if="active === 'Address Settings'"/>
        <RoleSettings :agency="agency" :facilities="selected.data.facilities" v-if="active === 'Role Settings'"/>
    </div>
</template>
<script>
import FormSettings from './FormSettings.vue';
import AddressSettings from './AddressSettings.vue';
import RoleSettings from './RoleSettings.vue';
export default {
    components: { FormSettings, AddressSettings, RoleSettings },
    props: ['selected', 'addressComponents', 'agency'],
    data(){
        return {
            tabs: ['Form Settings', 'Address Settings', 'Role Settings'],
            active: 'Form Settings',
        }
    }
}
</script>
