<template>
    <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i class="ri-user-fill text-primary fs-24"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">{{year}} Laboratory Breakdown</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">A graph highlighting active laboratories, no. of personnel, and customer transactions for a quick overview of key metrics.</p>
                </div>
            </div>
        </div>
        <div class="card-body bg-white border-bottom">
            <apexchart ref="realtimeChart" class="apex-charts" type="line" dir="ltr" :series="series"
                :options="chartOptions">
            </apexchart>
        </div>
        <div class="card-body"></div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            year: new Date().getFullYear(),
            series: [],
            chartOptions: {
                chart: {height: 320, toolbar: {show: false}},
                stroke: {curve: 'smooth', width: 2},
                markers: {
                    size: [0, 0, 0],
                    strokeWidth: 2,
                    hover: { size: 4 },
                },
                xaxis: {
                    categories: [],
                    axisTicks: {show: false},
                    axisBorder: {show: false},
                },
                grid: {
                    show: true,
                    xaxis: {lines: {show: true}},
                    yaxis: {lines: { show: false}},
                    padding: { top: 0, right: -2, bottom: 15, left: 10 },
                },
                legend: {
                    show: true,
                    horizontalAlign: "center",
                    offsetX: 0,
                    offsetY: -5,
                    markers: {width: 9, height: 9, radius: 6},
                    itemMargin: { horizontal: 10, vertical: 0 },
                },
                dataLabels: {
                    enabled: false,
                },
                colors: ["#34c38f", "#556ee6", "#ea6868", "#f1b44c", "#a20cce"],
            },
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch() {
            axios.get(this.currentUrl + '/insights/laboratories', {
                params : {
                    option : 'breakdown',
                    year: this.year
                }
            })
            .then(response => {
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: response.data.categories
                        }
                    }
                };
                this.series = response.data.lists;

                this.$nextTick(() => {
                    setTimeout(() => {
                        window.dispatchEvent(new Event('resize'));
                    }, 100);
                });
            })
            .catch(err => console.log(err));
        },
        updateYear(year){
            this.year = year;
            this.fetch();
        },
        previous(year){
            this.year = year - 1;
            this.fetch();
        },
        next(year){
            this.year = year + 1;
            this.fetch();
        }
    }
}
</script>
