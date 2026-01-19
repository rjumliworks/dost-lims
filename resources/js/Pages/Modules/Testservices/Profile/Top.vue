<template>
    <b-row>
        <b-col lg="12">
            <b-card no-body class="mt-n4 mx-n4">
                <div class="bg-warning-subtle">
                    <b-card-body class="pb-0 px-4">
                        <b-row class="mb-3">
                            <b-col md>
                                <b-row class="align-items-center g-3">
                                    <!-- <b-col md="auto">
                                        <div class="avatar-md">
                                            <span :class="'avatar-title rounded-circle bg-primary text-white fs-24'">{{service.data.testname.name[0]}}</span>
                                        </div>
                                    </b-col> -->
                                    <b-col md>
                                        <div>
                                            <h4 class="fw-bold">{{service.data.testname.name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><i class="ri-building-line align-bottom me-1"></i>{{ service.data.laboratory.name }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Method : </span>{{ service.data.method.method.name }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Reference : </span>{{ service.data.method.reference.name  }}</div>
                                               
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="auto">
                                <div class="hstack gap-4 flex-wrap" style="margin-top: 13px;">
                                    <Link href="/testservices">
                                        <div class="text-muted" @click="hide()">  
                                            <i class="ri-close-circle-fill fs-16"></i> Close
                                        </div>
                                    </Link>
                                    <div class="vr" v-if="$page.props.roles[0] == 'Technical Manager'" style="width: 1px;"></div>
                                    <div v-if="service.data.status.name === 'Pending' && $page.props.roles[0] == 'Technical Manager'">  
                                        <b-button @click="submit(32)" variant="primary" block><i class="ri-save-fill me-1"></i> Approved</b-button>
                                    </div>
                                    <div v-else-if="service.data.status.name === 'Approved'">  
                                        <b-button @click="submit(33)" variant="danger" block><i class="ri-save-fill me-1"></i> Suspend</b-button>
                                    </div>
                                    <div v-else-if="service.data.status.name === 'Suspended' && $page.props.roles[0] == 'Technical Manager'">  
                                        <b-button @click="submit(32)" variant="success" block><i class="ri-save-fill me-1"></i> Reactive</b-button>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        
                    </b-card-body>
                </div>
            </b-card>
        </b-col>
    </b-row>
</template>
<script>
export default {
    props: ['service'],
}
</script>
