<template>
    <div id="user-form">
        <div class="card">
            <div class="card-body">
                <legend v-if="user.id !== ''">Edit User</legend>
                <legend v-else>New User</legend>
                <div>
                    <div class="form-group">
                        <label for="user-name">Name</label>
                        <input type="text" v-model="componentUser.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" id="user-name" placeholder="Name">

                        <error-message v-bind:errors="errors.name"></error-message>
                    </div>
                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input type="email" v-model="componentUser.email" class="form-control" v-bind:class="{ 'is-invalid': errors.email }" id="user-email" placeholder="Email">

                        <error-message v-bind:errors="errors.email"></error-message>
                    </div>
                    <div class="form-group">
                        <label for="user-company">Company</label>
                        <select class="form-control" v-model="componentUser.company_id" v-bind:class="{ 'is-invalid': errors.company_id }" id="user-company" >
                            <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                        </select>

                        <error-message v-bind:errors="errors.company_id"></error-message>
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
        name: 'user-form',
        props: ['user'],
        components: { ErrorMessage },
        data: function () {
            return {
                companies: [],
                errors: [],
                componentUser: {},
            }
        },
        watch: {
            user: function() {
                this.componentUser = this.user;
                this.errors = [];
            },
        },
        created: function () {
            var vm = this;
            axios.get('/api/companies')
                .then(function(response){
                    vm.companies = response.data.data;
                })
        },
        methods: {
            submitForm: function () {
                this.errors = [];
                if (this.componentUser.id !== '') {
                    this.update();
                } else {
                    this.store();
                }
            },
            update: function() {
                var vm = this;
                axios.patch('/api/users/' + this.componentUser.id, this.componentUser)
                    .then(function (response) {
                        vm.componentUser = {
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
                axios.post('/api/users', this.componentUser)
                    .then(function (response) {
                        vm.componentUser = {
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