<template>
   <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
       <simplebar data-simplebar style="height: calc(100vh - 410px);">
           <table class="table table-nowrap align-middle mb-0">
                <thead class="bg-primary text-white thead-fixed">
                    <tr class="fs-10">
                        <th style="width: 4%;"></th>
                        <th>Funding Source</th>
                        <th style="width: 18%;" class="text-center">Code</th>
                        <th style="width: 10%;" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody v-if="lists.length > 0">
                    <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                        <td>{{ index + 1 }}.</td>
                        <td>{{list.source}}</td>
                        <td class="text-center">{{list.code || '-'}}</td>
                        <td class="text-center fs-12">
                            <span v-if="list.is_active" class="badge bg-success">Active</span>
                            <span v-else class="badge bg-danger">Inactive</span>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" class="text-center text-muted">No records found.</td>
                    </tr>
               </tbody>
           </table>
       </simplebar>
   </div>
</template>
<script>
export default {
    props: ['lists']
}
</script>
