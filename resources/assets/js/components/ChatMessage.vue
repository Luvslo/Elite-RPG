<template>
    <div class="chat-message">
        <p>{{ item.message }}</p>
        <small>{{ item.user.name }}</small>
    </div>
</template>

<script>

export default {

  props: ['item']

}

</script>

<style lang="css">

.chat-message {
    padding: 1rem;
}
.chat-message > p {
    margin-bottom: .5rem;
}

</style>
