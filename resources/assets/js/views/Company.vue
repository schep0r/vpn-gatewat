<template>
    <div id="companies">
        <h3>
            Companies
            <div class="float-right">
                <button class="btn btn-sm btn-primary" v-show="!formAble" v-on:click="toggleForm">Add</button>
                <button class="btn btn-sm btn-secondary" v-show="formAble" v-on:click="toggleForm">Close</button>
            </div>
        </h3>

        <company-form v-show="formAble" v-on:add-company="formSubmitMethod"></company-form>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quota</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="company in companies">
                    <td>{{ company.name }}</td>
                    <td>{{ company.quota }}</td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="#">edit</a>
                        <button class="btn btn-sm btn-danger" v-on:click='destroy(company)'>delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from 'axios'
    import CompanyForm from './CompanyForm'

    export default {
        name: 'companies',
        components: { CompanyForm },
        data: function () {
            return {
                companies: [],
                formAble: false,
            }
        },
        created: function () {
            var vm = this;
            axios.get('http://127.0.0.1:8000/api/companies')
                .then(function(response){
                    vm.companies = response.data;
                })
        },
        methods: {
            toggleForm: function () {
                this.formAble = !this.formAble;
            },
            formSubmitMethod: function (data) {
                this.companies.push(data);
            },
            destroy: function (company) {
                var approved = confirm('Are you sure?');
                if (approved) {
                    var vm = this;
                    let idx = vm.companies.indexOf(company)
                    axios.delete('http://127.0.0.1:8000/api/companies/' + company.id)
                        .then(function(){
                            vm.companies.splice(idx,1)
                            alert('Company was deleted!');
                        });
                }
            }
        }
    }
</script>