<template>
    <div id="company-form">
        <div class="card">
            <div class="card-body">
                <legend v-if="company.id !== ''">Edit Company</legend>
                <legend v-else>New Company</legend>
                <div>
                    <div class="form-group">
                        <label for="company-name">Name</label>
                        <input type="text" v-model="componentCompany.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" id="company-name" placeholder="Name">

                        <error-message v-bind:errors="errors.name"></error-message>
                    </div>
                    <div class="form-group">
                        <label for="company-quota">Quota (Bytes)</label>
                        <input type="text" v-model="componentCompany.quota" class="form-control" v-bind:class="{ 'is-invalid': errors.quota }" id="company-quota" placeholder="Quota (Bytes)">

                        <error-message v-bind:errors="errors.quota"></error-message>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" v-on:click="submitForm">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMessage from './ErrorMessage';

    export default {
        name: 'company-form',
        props: ['company'],
        components: { ErrorMessage },
        data: function () {
            return {
                componentCompany: {},
                errors: [],
            }
        },
        watch: {
            company: function(){
                this.componentCompany = this.company;
                this.errors = [];
            }
        },
        methods: {
            submitForm: function () {
                this.errors = [];
                if (this.componentCompany.id !== '') {
                    this.update();
                } else {
                    this.store();
                }
            },
            update: function() {
                var vm = this;
                axios.patch('/api/companies/' + this.componentCompany.id, this.componentCompany)
                    .then(function (response) {
                        vm.componentCompany = {
                            id: '',
                            name: '',
                            quota: ''
                        };
                        vm.$emit('edit-company', response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                            vm.errors = error.response.data.errors;
                        }
                    });
            },
            store: function () {
                var vm = this;
                axios.post('/api/companies', this.componentCompany)
                    .then(function (response) {
                        vm.componentCompany = {
                            id: '',
                            name: '',
                            quota: ''
                        };
                        vm.$emit('add-company', response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                            vm.errors = error.response.data.errors;
                        }
                    });
            }
        }
    }
</script>