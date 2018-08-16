<template>
    <div id="company-form">
        <div class="card">
            <div class="card-body">
                <legend v-if="company.id !== ''">Edit Company</legend>
                <legend v-else>New Company</legend>
                <div>
                    <div class="form-group">
                        <label for="company-name">Name</label>
                        <input type="text" v-model="company.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" id="company-name" placeholder="Name">
                        <div v-show="errors.name" class="invalid-feedback">
                            <p v-for="error in errors.name"> {{ error }} </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company-quota">Quota (Bytes)</label>
                        <input type="text" v-model="company.quota" class="form-control" v-bind:class="{ 'is-invalid': errors.quota }" id="company-quota" placeholder="Quota (Bytes)">
                        <div v-show="errors.quota" class="invalid-feedback">
                            <p v-for="error in errors.quota"> {{ error }} </p>
                        </div>
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
    export default {
        name: 'company-form',
        props: ['company'],
        data: function () {
            return {
                errors: [],
            }
        },
        methods: {
            submitForm: function () {
                this.errors = [];
                if (this.company.id !== '') {
                    this.update();
                } else {
                    this.store();
                }
            },
            update: function() {
                var vm = this;
                axios.patch('http://127.0.0.1:8000/api/companies/' + this.company.id, this.company)
                    .then(function (response) {
                        vm.company = {
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
                axios.post('http://127.0.0.1:8000/api/companies', this.company)
                    .then(function (response) {
                        vm.company = {
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