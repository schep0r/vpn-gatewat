<template>
    <div id="company-form">
        <legend>New Company</legend>
        <div>
            <div class="form-group">
                <label for="user-name">Name</label>
                <input type="text" v-model="company.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" id="user-name" placeholder="Name">
                <div v-show="errors.quota" class="invalid-feedback">
                    <p v-for="error in errors.name"> {{ error }} </p>
                </div>
            </div>
            <div class="form-group">
                <label for="company-quota">Quota (B)</label>
                <input type="text" v-model="company.quota" class="form-control" v-bind:class="{ 'is-invalid': errors.quota }" id="company-quota" placeholder="Quota (B)">
                <div v-show="errors.quota" class="invalid-feedback">
                    <p v-for="error in errors.quota"> {{ error }} </p>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" v-on:click="submitForm">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'company-form',
        data: function () {
            return {
                company: {
                    name: '',
                    quota: ''
                },
                errors: [],
            }
        },
        methods: {
            submitForm: function () {
                var vm = this;
                vm.errors = [];
                axios.post('http://127.0.0.1:8000/api/companies', vm.company)
                    .then(function (response) {
                        vm.company = {
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