<template>
    <div>
        <h1>VPN Gateway</h1>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'users' }">Users</router-link> |
            <router-link :to="{ name: 'companies' }">Companies</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {}
</script>