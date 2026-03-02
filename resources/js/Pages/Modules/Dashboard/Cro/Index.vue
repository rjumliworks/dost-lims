<template>
    <Head title="Dashboard" />
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <BRow>
        <BCol>
            <div class="h-100">

                <BRow>
                    <BCol cols="12" class="mb-3 mt-n2">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">Summary View</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Here's what's happening with the laboratory for month of</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <BForm action="javascript:void(0);">
                                    <BRow class="g-3 mb-0 align-items-center">
                                        <BCol sm="auto">
                                            <div class="input-group">
                                                <flat-pickr v-model="date" :config="config"
                                                    class="form-control border-0 dash-filter-picker shadow">
                                                </flat-pickr>

                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </BCol>
                                        <div class="col-auto">
                                            <BButton type="button" variant="soft-success">
                                                <i class="ri-add-circle-line align-middle me-1"></i>
                                                Add Product
                                            </BButton>
                                        </div>
                                        <div class="col-auto">
                                            <BButton type="button" variant="soft-info"
                                                class="btn-icon waves-effect layout-rightside-btn" @click="rightcolumn">
                                                <i class="ri-pulse-line"></i>
                                            </BButton>
                                        </div>
                                    </BRow>
                                </BForm>
                            </div>
                        </div>
                    </BCol>
                </BRow>


            </div>
        </BCol>
        <div class="col-auto layout-rightside-col d-block">
        <div class="overlay" @click="hiderightcolumn"></div>
        <div class="layout-rightside">
            <BCard no-body class="h-100 rounded-0">
                    <BCardBody class="p-0">
                    
                    </BCardBody>
            </BCard>
        </div>
      </div>
    </BRow>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: {
        PageHeader
    },
    methods: {
    rightcolumn() {
      if (document.querySelector('.layout-rightside-col').classList.contains('d-block')) {
        document.querySelector('.layout-rightside-col').classList.remove('d-block');
        document.querySelector('.layout-rightside-col').classList.add('d-none');
      } else {
        document.querySelector('.layout-rightside-col').classList.remove('d-none');
        document.querySelector('.layout-rightside-col').classList.add('d-block');
      }
    },

    resizerightcolumn() {
      const element = document.querySelector('.layout-rightside-col');

      if (element) {
        if (window.outerWidth < 1699) {
          element.classList.remove("d-block");
          element.classList.add("d-none");
        } else {
          element.classList.add("d-block");
          element.classList.remove("d-none");
        }
      }

      if (document.documentElement.getAttribute("data-layout") === "semibox") {
        element.classList.remove("d-block");
        element.classList.add("d-none");
      }
    },

    hiderightcolumn() {
      const element = document.querySelector('.layout-rightside-col');
      if (element.classList.contains('d-block')) {
        element.classList.remove("d-block");
        element.classList.add("d-none");
      }
    }
  },

}

</script>
