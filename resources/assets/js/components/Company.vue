<template>
    <div id="companies" class="mt-3">
        <div class="row">
            <div class="col-md-10">
                <h3>Companies</h3>
            </div>
            <div class="col-md-2 text-right">
                <button class="btn btn-sm btn-primary" v-show="!formAble" v-on:click="add">Add</button>
                <button class="btn btn-sm btn-secondary" v-show="formAble" v-on:click="toggleForm">Close</button>
            </div>
        </div>

        <company-form v-show="formAble" v-on:add-company="addSubmitMethod" v-on:edit-company="editSubmitMethod" v-bind:company="editCompany"></company-form>

        <div class="row">
            <div class="col-md-12">
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
                            <td>{{ company.user_quota_view }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" v-on:click='edit(company)'>edit</button>
                                <button class="btn btn-sm btn-danger" v-on:click='destroy(company)'>delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CompanyForm from './CompanyForm'

    export default {
        name: 'companies',
        components: { CompanyForm },
        data: function () {
            return {
                companies: [],
                formAble: false,
                editCompany: {id: '', name: '', quota: ''},
            }
        },
        created: function () {
            var vm = this;
            axios.get('/api/companies')
                .then(function(response){
                    vm.companies = response.data;
                })
        },
        methods: {
            toggleForm: function () {
                this.formAble = !this.formAble;
            },
            addSubmitMethod: function (data) {
                this.companies.push(data);
            },
            editSubmitMethod: function (data) {
                let idx = this.companies.indexOf(this.editCompany);
                this.companies[idx] = data;
                this.editCompany = {id: '', name: '', quota: ''};
                this.toggleForm();
            },
            add: function () {
                this.editCompany = {id: '', name: '', quota: ''};
                this.toggleForm();
            },
            edit: function (company) {
                if (!this.formAble) {
                    this.toggleForm();
                }
                this.editCompany = company;
            },
            destroy: function (company) {
                var approved = confirm('Are you sure?');
                if (approved) {
                    var vm = this;
                    let idx = vm.companies.indexOf(company);
                    axios.delete('/api/companies/' + company.id)
                        .then(function(){
                            vm.companies.splice(idx,1);
                            alert('Company was deleted!');
                        });
                }
            }
        }
    }
</script>