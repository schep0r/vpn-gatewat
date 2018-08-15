<template>
    <div id="users">
        <h3>Users</h3>
        <button class="btn btn-sm btn-primary" v-show="!addFormAble" v-on:click="toggleAddUserForm">Add</button>
        <button class="btn btn-sm btn-secondary" v-show="addFormAble" v-on:click="toggleAddUserForm">Close</button>
        <add-users-form v-show="addFormAble" v-on:submitForm="toggleAddUserForm"></add-users-form>
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
                    <a class="btn btn-sm btn-warning" href="#">edit</a>
                    <button class="btn btn-sm btn-danger" v-on:click="destroy(user)">delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from 'axios'
    import AddUsersForm from "./AddUserForm";

    export default {
        name: 'users',
        components: {AddUsersForm},
        data: function () {
            return {
                users: [],
                addFormAble: false,
            }
        },
        created: function () {
            console.log('created');
            var vm = this;
            axios.get('http://127.0.0.1:8000/api/users')
                .then(function(response){
                    vm.users = response.data;
                })
        },
        methods: {
            toggleAddUserForm: function () {
                this.addFormAble = !this.addFormAble;
            },
            destroy: function (user) {
                var approved = confirm('Are you sure?');
                if (approved) {
                    var vm = this;
                    let idx = vm.users.indexOf(user)
                    axios.delete('http://127.0.0.1:8000/api/users/' + user.id)
                        .then(function(){
                            vm.users.splice(idx,1);
                            alert('User was deleted!');
                        });
                }
            }
        }
    }
</script>