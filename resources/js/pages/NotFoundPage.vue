<template>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Page Not Found</h1>
            <p class="lead">The page you are looking for is not found</p>
            <hr class="my-4">
            <router-link class="btn btn-primary btn-lg" :to="{ name: 'home'}">Back to home page</router-link>
        </div>
    </div>
</template>
