<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">VPN Gateway</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <router-link class="nav-item" tag="li" active-class="active" :to="{ name: 'home' }" exact>
                        <a class="nav-link">Home</a>
                    </router-link>

                    <router-link class="nav-item" tag="li" active-class="active" :to="{ name: 'users' }" exact>
                        <a class="nav-link">Users</a>
                    </router-link>

                    <router-link class="nav-item" tag="li" active-class="active" :to="{ name: 'companies' }" exact>
                        <a class="nav-link">Companies</a>
                    </router-link>

                    <router-link class="nav-item" tag="li" active-class="active" :to="{ name: 'abusers' }" exact>
                        <a class="nav-link">Abusers</a>
                    </router-link>
                </ul>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>