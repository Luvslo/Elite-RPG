<template>
  <div class="chat-composer">
      <input
        type="text"
        placeholder="Start typing your message..."
        v-model="message"
        v-on:keyup.enter="addText"
      >
      <button class="btn btn-primary" @click="addText">Send</button>
  </div>
</template>

<script>

export default {
    props: ['user'],

    /* data to pass to the view */
    data() {
        return {
            message: ''
        }
    },

    /* methods */
    methods: {

        /* emit - prepare items array (message, user) */
        addText: function() {
            this.$emit('send', {
                message: this.message,
                user: this.user
            });
            this.message = '';
        }
    }
}

</script>

<style lang="css">
.chat-composer {
    display: flex;
}
.chat-composer input {
    flex: 1 auto;
}
.chat-composer button {
    border-radius: 0;
}
</style>
