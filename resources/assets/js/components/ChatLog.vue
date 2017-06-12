<template>
    <div class="chat-log">
        <chat-message v-for="item in items" v-bind:item="item"></chat-message>
    </div>
</template>

<script>
export default {
    props: ['items']
}
</script>

<style lang="css">
.chat-log .chat-message:nth-child(even) {
    background-color: #ccc;
}
</style>
