<template>
    <div id="users" class="mt-3">
        <div class="row">
            <div class="col-md-10">
                <h3>Users</h3>
            </div>
            <div class="col-md-2 text-right">
                <button class="btn btn-sm btn-primary" v-show="!formAble" v-on:click="add">Add</button>
                <button class="btn btn-sm btn-secondary" v-show="formAble" v-on:click="toggleForm">Close</button>
            </div>
        </div>

        <users-form v-show="formAble" v-on:add-user="addSubmitMethod" v-on:edit-user="editSubmitMethod" v-bind:user="selectedUser"></users-form>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.company.name }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" v-on:click="edit(user)">edit</button>
                                <button class="btn btn-sm btn-danger" v-on:click="destroy(user)">delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import UsersForm from "./UserForm";

    export default {
        name: 'users',
        components: { UsersForm },
        data: function () {
            return {
                users: [],
                selectedUser: {id: '', name: '', email: '', company_id: ''},
                emptyUser: {id: '', name: '', email: '', company_id: ''},
                formAble: false,
            }
        },
        created: function () {
            var vm = this;
            axios.get('/api/users')
                .then(function(response){
                    vm.users = response.data.data;
                    console.log(vm.users);
                })
        },
        methods: {
            toggleForm: function () {
                this.formAble = !this.formAble;
            },
            addSubmitMethod: function (data) {
                this.users.push(data);
            },
            editSubmitMethod: function (data) {
                let idx = this.users.indexOf(this.selectedUser);
                this.users[idx] = data;
                this.selectedUser = this.emptyUser;
                this.toggleForm();
            },
            add: function () {
                this.selectedUser = this.emptyUser;
                this.toggleForm();
            },
            edit: function (user) {
                if (!this.formAble) {
                    this.toggleForm();
                }
                this.selectedUser = user;
            },
            destroy: function (user) {
                var approved = confirm('Are you sure?');
                if (approved) {
                    var vm = this;
                    let idx = vm.users.indexOf(user)
                    axios.delete('/api/users/' + user.id)
                        .then(function(){
                            vm.users.splice(idx,1);
                            alert('User was deleted!');
                        });
                }
            }
        }
    }
</script>