<template>
    <div id="abusers">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-inline">

                            <select class="form-control mb-2 mr-sm-2" v-model="selectedMonth" id="month" >
                                <option v-for="month in months" v-bind:value="month.number" >{{ month.name }}</option>
                            </select>

                            <button class="btn btn-primary mb-2 mr-sm-2" v-on:click="report">
                                <span v-show="reportInProgress" class="fa fa-spinner fa-spin"></span> Show report
                            </button>

                            <button class="btn btn-secondary mb-2" v-on:click="generate">
                                <span v-show="generateInProgress" class="fa fa-spinner fa-spin"></span> Generate data
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">

                <ul v-show="reported" class="list-group">
                    <li class="list-group-item" v-for="company in reportCompanies">
                        <span>{{ company.name }}</span> <span class="mr-3 ml-3">{{ company.user_traffic_view }}</span> ({{ company.user_quota_view }})
                    </li>
                    <li class="list-group-item" v-if="reportCompanies.length === 0">
                        <i>Empty Result</i>
                    </li>
                </ul>

                <div v-show="generated" class="card">
                    <div class="card-body">
                        <p>There were generated: <b>{{ transfersCount }} records</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'abusers',
        data: function () {
            return {
                months: [
                    {number: 1, name: "January"},
                    {number: 2, name: "February"},
                    {number: 3, name: "March"},
                    {number: 4, name: "April"},
                    {number: 5, name: "May"},
                    {number: 6, name: "June"},
                    {number: 7, name: "July"},
                    {number: 8, name: "August"},
                    {number: 9, name: "September"},
                    {number: 10, name: "October"},
                    {number: 11, name: "November"},
                    {number: 12, name: "December"}
                ],
                selectedMonth: 1,
                reportCompanies: [],
                reportInProgress: false,
                reported: false,
                transfersCount: null,
                generateInProgress: false,
                generated: false,
            }
        },
        methods: {
            report: function() {
                this.reportInProgress = true;
                var vm = this;

                axios.get("/api/report/" + this.selectedMonth)
                    .then(function(response){
                        vm.reportCompanies = response.data;
                        vm.reportInProgress = false;
                        vm.reported = true;
                        vm.generated = false;
                    })
            },

            generate: function() {
                this.generateInProgress = true;
                var vm = this;

                axios.post("/api/generate")
                    .then(function(response){
                        vm.generateInProgress = false;
                        vm.transfersCount = response.data.transfers_count;
                        vm.reported = false;
                        vm.generated = true;
                    })
            }
        }
    }
</script>