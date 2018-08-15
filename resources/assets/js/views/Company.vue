<template>
    <div id="companies">
        <h3>Companies</h3>
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

    export default {
        name: 'companies',
        data: function () {
            return {
                companies: [],
            }
        },
        created: function () {
            console.log('created');
            var vm = this;
            axios.get('http://127.0.0.1:8000/api/companies')
                .then(function(response){
                    vm.companies = response.data;
                })
        },
        methods: {
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