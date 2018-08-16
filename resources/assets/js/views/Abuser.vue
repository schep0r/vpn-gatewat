<template>
    <div id="abusers">
        <div class="card mt-3">
            <div class="card-body">
                <div class="form-inline">

                    <select class="form-control mb-2 mr-sm-2" v-model="selectedMonth" id="month" >
                        <option v-for="month in months" v-bind:value="month.number" >{{ month.name }}</option>
                    </select>

                    <button class="btn btn-primary mb-2 mr-sm-2" v-on:click="report">Show report</button>

                    <button class="btn btn-secondary mb-2">Generate data</button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

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
                selectedMonth: null,
                reportCompanies: [],
            }
        },
        methods: {
            report: function() {
                var vm = this;

                axios.get("/api/report/" + this.selectedMonth)
                    .then(function(response){
                        vm.reportCompanies = response.data;
                    })
            },

            generate: function() {

            }
        }
    }
</script>