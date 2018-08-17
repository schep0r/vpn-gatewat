<template>
    <div v-show="errors" class="invalid-feedback">
        <p v-for="error in errors"> {{ error }} </p>
    </div>
</template>

<script>
    export default {
        name: 'error-message',
        props: ['errors'],
        data: function () {
            return {

            }
        },
    }
</script>