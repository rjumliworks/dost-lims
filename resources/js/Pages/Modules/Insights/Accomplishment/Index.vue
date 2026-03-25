<template lang="">
    <Head title="Target vs Accomplishment"/>
    <div class="auth-page-wrapper d-flex min-vh-100">
        <div class="auth-page-content">
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <div class="file-manager-content w-100 p-4 pb-0" ref="box">
                     <b-row class="mt-2">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" placeholder="Accomplishments" class="form-control" style="width: 40%;">
                                <Multiselect class="white" style="width: 15%;" :options="types" v-model="type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" />
                                <Multiselect class="white" style="width: 15%;" :options="years" v-model="year" label="name" :allow-empty="false" :searchable="true" placeholder="Select Year" />
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-search-eye-fill align-bottom"></i>
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <div class="table-responsive" style="margin-top: 5px; height: calc(100vh - 80px); overflow: auto; position: relative;">
                        <div v-if="loading" class="table-overlay">
                            <div class="overlay-bg"></div>
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-bordered table-nowrap align-middle">
                            <thead class="thead-fixed text-white">
                                <tr>
                                    <th colspan="22" class="text-center align-middle bg-primary ">{{year}} Target vs Accomplishment</th>
                                </tr>
                                <tr class="fs-10">
                                    <th class="text-center align-middle bg-dark" style="width: 3%;">No.</th>
                                    <th class="text-center align-middle bg-dark" style="width: 15%;">KPI</th>
                                    <th class="text-center align-middle bg-danger" style="width: 5%;">Target</th>
                                    <th v-if="type == 'Quarters'" @click="selectColumn(index)" class="text-center align-middle bg-info" v-for="(list,index) in quarters" v-bind:key="index"
                                    :class="{'bg-dark text-white fw-semibold': selectedColumn === index}" style="cursor: pointer;">{{list}}</th>
                                    <th v-if="type == 'Months'" @click="selectColumn(index)" class="text-center align-middle bg-info" v-for="(list,index) in months" v-bind:key="index" 
                                    :class="{'bg-dark text-white fw-semibold': selectedColumn === index}" style="cursor: pointer;">{{list}}</th>
                                    <!-- <th class="text-center align-middle bg-danger" style="width: 6%;">Total Target</th> -->
                                    <th class="text-center align-middle bg-success" style="width: 8%;">Total</th>
                                    <th class="text-center align-middle bg-success" style="width: 4%;">%</th>
                                </tr>
                            </thead>
                            <tbody class="fs-10">
                            <template v-for="(objectives, typeName, typeIndex) in kpis" :key="typeName">
                                    <tr class="bg-dark opacity-75 text-white">
                                        <th>{{typeIndex+1+'.00'}}</th>
                                        <th :colspan="(type == 'Months') ? 17 : 9">{{ typeName }}</th>
                                    </tr>
                                    <template v-for="(objective, oIndex) in objectives" :key="objective.name">
                                        <tr class="bg-info-subtle fw-semibold" @click="toggleRow(typeIndex + '-' + oIndex)" style="cursor: pointer;">
                                            <td>{{ (typeIndex+1)+'.'+ (oIndex + 1).toString().padStart(2, '0') }}</td>
                                            <td>{{ objective.name }}</td>
                                            <td class="text-center" @click="setOverallTarget(objective)">{{ (objective.is_amount) ? formatMoney(objective.target) : formatNumber(objective.target) }}</td>
                                            <template v-if="type == 'Months'" v-for="(m, xIndex) in objective.monthly" :key="xIndex">
                                                <td v-if="objective.is_amount" class="text-center" :class="{'bg-dark text-white fw-semibold': selectedColumn === xIndex}">{{formatMoney(m.accomplish)}}</td>
                                                <td v-else class="text-center" :class="{'bg-dark text-white fw-semibold': selectedColumn === xIndex}">{{m.accomplish}}</td>
                                            </template>
                                            <template v-if="type == 'Quarters'">
                                                <td v-for="(q, qqIndex) in groupByQuarter(objective.monthly,objective.is_amount)" :key="'q' + qqIndex" class="text-center"
                                                :class="{'bg-dark text-white fw-semibold': selectedColumn === qqIndex}">
                                                    <span v-if="objective.is_amount">{{ formatMoney(q.accomplish) }}</span>
                                                    <span v-else>{{ q.accomplish }}</span>
                                                </td>
                                            </template>
                                            <td v-if="objective.is_amount" class="text-center">{{ formatMoney(objective.accomplish) }}</td>
                                            <td v-else class="text-center">{{ formatNumber(objective.accomplish) }}</td>
                                            <td class="text-center">{{ objective.percentage }}</td>
                                        </tr>
                                        <template v-if="!objective.is_consolidated"> 
                                            <!-- && expandedRows[typeIndex + '-' + oIndex -->
                                            <tr style="cursor: pointer;" v-for="(breakdown, bIndex) in objective.breakdown" :key="`breakdown-${index}-${bIndex}`" @click="selectRow(`breakdown-${oIndex}-${bIndex}`)" 
                                            :class="{'bg-dark text-white fw-semibold': selectedRow === `breakdown-${oIndex}-${bIndex}`}">
                                                <td class="text-center"></td>
                                                <td class="ps-4">{{ breakdown.name || '-' }}</td>
                                                <td v-if="objective.is_amount" class="text-center" @click="setTarget(objective.name,breakdown)">-
                                                    <!-- {{ formatMoney(breakdown.target) }} -->
                                                </td>
                                                <td v-else class="text-center" @click="setTarget(objective.name,breakdown)">-</td> 
                                                <!-- {{ breakdown.target }} -->
                                                <template v-if="type == 'Months'" v-for="(m, mIndex) in breakdown.months" :key="mIndex">
                                                    <td v-if="objective.is_amount" class="text-center" :class="{'bg-dark text-white fw-semibold': selectedColumn === mIndex}">{{formatMoney(m.accomplish)}}</td>
                                                <td v-else class="text-center" :class="{'bg-dark text-white fw-semibold': selectedColumn === mIndex}">{{m.accomplish}}</td>
                                                </template>
                                                <template v-if="type == 'Quarters'">
                                                    <td v-for="(q, qIndex) in groupByQuarter(breakdown.months,objective.is_amount)" :key="'q' + qIndex" class="text-center" 
                                                    :class="{'bg-dark text-white fw-semibold': selectedColumn === qIndex}">
                                                        <span v-if="objective.is_amount">{{ formatMoney(q.accomplish) }}</span>
                                                        <span v-else>{{ q.accomplish }}</span>
                                                    </td>
                                                </template>
                                                <td v-if="objective.is_amount" class="text-center">-</td>
                                                <!-- {{ formatMoney(breakdown.accomplish) }} -->
                                                <td v-else class="text-center">{{ formatNumber(breakdown.accomplish) }}</td>
                                                <td class="text-center">-</td>
                                                <!-- {{ breakdown.percentage }}  -->
                                            </tr>
                                      </template>
                                    </template>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Target ref="target"/>
</template>
<script>
import Target from './Modals/Target.vue';
import Multiselect from "@vueform/multiselect";
export default {
    layout: null,
    components: { Multiselect, Target },
    props: ['years'],
data(){
        return {
            loading: false,
            year: new Date().getFullYear(),
            selectedRow: null,
            months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            quarters: ['1st Quarter','2nd Quarter','3rd Quarter','4th Quarter'],
            types: ['Months','Quarters'],
            type: 'Months',
            selectedRow: null, 
            selectedColumn: null,
            expandedRows: {},
            kpis: [],
        }
    },
    computed: {
        quarterlySummary() {
            const quarters = [
                { quarter: "Q1", months: ["Jan", "Feb", "Mar"] },
                { quarter: "Q2", months: ["Apr", "May", "Jun"] },
                { quarter: "Q3", months: ["Jul", "Aug", "Sep"] },
                { quarter: "Q4", months: ["Oct", "Nov", "Dec"] }
            ];

            return quarters.map(q => {
                const total = this.monthlyData
                .filter(m => q.months.includes(m.name))
                .reduce((sum, m) => sum + m.accomplish, 0);

                return {
                    quarter: q.quarter,
                    accomplish: total,
                    is_amount: 0 
                };
            });
        }
    },
    watch: {
        'year'(val) {
            this.fetch();
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            this.loading = true;
            axios.get('/accomplishments',{
                params : {
                    year: this.year,
                    option: 'targets',
                }
            })
            .then(response => {
                this.kpis = response.data;         
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.loading = false;
            });
        },
        toggleRow(index) {
           this.expandedRows[index] = !this.expandedRows[index];
        },
        groupByQuarter(months,is_amount) {
            const quarterMap = {
            Q1: ["Jan", "Feb", "Mar"],
            Q2: ["Apr", "May", "Jun"],
            Q3: ["Jul", "Aug", "Sep"],
            Q4: ["Oct", "Nov", "Dec"]
            };

            return Object.entries(quarterMap).map(([quarter, qMonths]) => {
            const matching = months.filter(m => qMonths.includes(m.name));
            const total = matching.reduce((sum, m) => {
                const val = Number(m.accomplish) || 0;
                return sum + val;
            }, 0);

            return {
                quarter,
                accomplish: total,
                months: matching // to keep the original breakdown if needed
            };
            });
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        formatNumber(value) {
            if (!value) return '0';
            return Number(value).toLocaleString(undefined, {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
            });
        },
        setTarget(objective,breakdown){
            this.$refs.target.show(objective,breakdown);
        },
        setOverallTarget(objective){
            this.$refs.target.show('Overall',objective);
        },
        selectRow(index) {
            this.selectedRow = (this.selectedRow == index) ? null : index;
        },
        selectColumn(index) {
            this.selectedColumn = (this.selectedColumn == index) ? null : index;
        },
        openCreate() {
            this.fetch();
        }
    }
}
</script>
<style scoped>
.auth-page-wrapper .auth-page-content {
    padding-bottom: 0px;
  width: 100%;
  overflow: hidden;
  background-color: #f3f3f9;
}
.file-manager-sidebar {
  min-width: 24%;
  max-width: 24%;
  height: calc(100vh - 92px);
}

.table-responsive {
  position: relative;
}

.table-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
}

.overlay-bg {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(3px);
}

.table-responsive table {
  position: relative;
  z-index: 1;
}
</style>
