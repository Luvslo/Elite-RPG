<template>
    <div class="elite-map">
        <canvas ref="mapCanvas" :width="300" :height="300"></canvas>
    </div>
</template>


<script>

/*
 *
 * Elite-RPG HTML5 Canavas / Websocket Map
 * @author  <theHeadTy@elite - Tyler S>
 * @copy Elite-RPG Gaming
 * http://i.imgur.com/3YGdYRy.png
 * 'http://torax.outwar.com/images/maptile/YAH.gif';
 *  v-on:mousedown="handleMouseDown" v-on:mouseup="handleMouseUp" v-on:mousemove="handleMouseMove"
 *
 */

export default {

    props: ['map'],

    methods: {

        drawMap: function(ctx) {
            var image = new Image();
            image.onload = function() {
                ctx.drawImage(image, 0, 0, image.width, image.height);
            }
            image.src = '';
        },

        drawPlayer: function(ctx) {
            var pimage = new Image();
            pimage.onload = function() {
                ctx.drawImage(pimage, 150, 150);
            }
            pimage.src = 'http://torax.outwar.com/images/maptile/YAH.gif';
        },

        gameLoop: function(ctx) {
            this.drawMap(ctx);
            this.drawPlayer(ctx);
        },

    },

    mounted() {

        const canvas = this.$refs.mapCanvas;
        const ctx = canvas.getContext('2d');

        this.gameLoop(ctx);

    }
}

</script>

<style>

.elite-map {

}

</style>
