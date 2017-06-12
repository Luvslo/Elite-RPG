<template>
    <div class="player-move"></div>
</template>

<script>

export default {

    data() {
        return {
            direction: '',
        }
    },

    methods: {

        previous: function (e) {
            if (e.keyCode == 37) {
                this.direction = 'left';
            }
            if (e.keyCode == 39) {
                this.direction = 'right';
            }
            if (e.keyCode == 38) {
                this.direction = 'up';
            }
            if (e.keyCode == 40) {
                this.direction = 'down';
            }
            this.$emit('send', this.direction);
            this.direction = '';
        }
    },

    created: function() {
        window.addEventListener('keyup', this.previous);

    },

    beforeDestroy: function () {
        // remove listener
    }
}
</script>
