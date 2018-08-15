<template>
    <div id="add-user-form">
        <h4>New Users</h4>
        <div>
            <div class="form-group">
                <label for="user-name">Name</label>
                <input type="text" v-model="name" class="form-control" id="user-name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="user-email">Email</label>
                <input type="email" v-model="email" class="form-control" id="user-email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="user-company">Company</label>
                <select class="form-control" v-model="selectedCompany" id="user-company" >
                    <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" v-on:click="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'add-users-form',
        data: function () {
            return {
                companies: [],
                name: '',
                email: '',
                selectedCompany: ''
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
                var vm = this;

                if (!vm.name || !vm.email || !vm.selectedCompany) {
                    return;
                }

                axios.post('http://127.0.0.1:8000/api/users', {
                    name: vm.name,
                    email: vm.email,
                    company_id: vm.selectedCompany
                })
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);

                    });

                this.$emit('submitForm')
            }
        }
    }
</script>