<template>
    <b-row>
        <b-col lg="12">
            <b-card no-body class="mt-n4 mx-n4">
                <div class="bg-warning-subtle">
                    <b-card-body class="pb-0 px-4">
                        <b-row class="mb-3">
                            <b-col md>
                                <b-row class="align-items-center g-3">
                                    <b-col md="auto">
                                        <div class="avatar-md">
                                            <span :class="'avatar-title rounded-circle bg-primary text-white fs-24'">{{selected.data.name[0]}}</span>
                                        </div>
                                    </b-col>
                                    <b-col md>
                                        <div>
                                            <h4 class="fw-bold">{{selected.data.member.name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><i class="ri-building-line align-bottom me-1"></i>{{ selected.data.name }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Code: </span>{{ selected.data.short }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Type : </span>{{ selected.data.type.name }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Member Since : </span>{{ (selected.data.member_since) ? selected.data.member_since : '-' }}</div>
                                                <div class="vr" style="width: 1px;"></div>
                                                <div><span class="text-muted">Contact no. : </span>{{ (selected.data.contact_no) ? selected.data.contact_no : '-' }}</div>
                                               
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="auto">
                                <div class="hstack gap-1 flex-wrap">
                                    <Link href="/agencies"><button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-share-line"></i>
                                    </button></Link>
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
    props: ['selected'],
    data(){
        return {
            currentUrl: window.location.origin,
        }
    }
}
</script>
