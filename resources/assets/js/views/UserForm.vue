<template>
    <div id="user-form">
        <div class="card">
            <div class="card-body">
                <legend v-if="user.id !== ''">Edit User</legend>
                <legend v-else>New User</legend>
                <div>
                    <div class="form-group">
                        <label for="user-name">Name</label>
                        <input type="text" v-model="user.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" id="user-name" placeholder="Name">
                        <div v-show="errors.name" class="invalid-feedback">
                            <p v-for="error in errors.name"> {{ error }} </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input type="email" v-model="user.email" class="form-control" v-bind:class="{ 'is-invalid': errors.email }" id="user-email" placeholder="Email">
                        <div v-show="errors.email" class="invalid-feedback">
                            <p v-for="error in errors.email"> {{ error }} </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-company">Company</label>
                        <select class="form-control" v-model="user.company_id" v-bind:class="{ 'is-invalid': errors.company_id }" id="user-company" >
                            <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                        </select>
                        <div v-show="errors.company_id" class="invalid-feedback">
                            <p v-for="error in errors.company_id"> {{ error }} </p>
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
        name: 'user-form',
        props: ['user'],
        data: function () {
            return {
                companies: [],
                errors: [],
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
            submitForm: function () {
                this.errors = [];
                if (this.user.id !== '') {
                    this.update();
                } else {
                    this.store();
                }
            },
            update: function() {
                var vm = this;
                axios.patch('http://127.0.0.1:8000/api/users/' + this.user.id, this.user)
                    .then(function (response) {
                        vm.user = {
                            id: '',
                            name: '',
                            email: '',
                            company_id: ''
                        };
                        vm.$emit('edit-user', response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                            vm.errors = error.response.data.errors;
                        }
                    });
            },
            store: function () {
                var vm = this;
                axios.post('http://127.0.0.1:8000/api/users', this.user)
                    .then(function (response) {
                        vm.user = {
                            id: '',
                            name: '',
                            email: '',
                            company_id: ''
                        };
                        vm.$emit('add-user', response.data);
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