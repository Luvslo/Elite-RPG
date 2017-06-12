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

    data() {
        return {
            x: 150,
            y: 150,
        }
    },

    methods: {

        getX: function() {
            return this.x;
        },

        getY: function() {
            return this.y;
        },

        drawMap: function(ctx, x, y) {
            //var context = document.createElement('canvas').getContext('2d');
            var mimage = new Image();
            mimage.onload = function() {
                ctx.drawImage(mimage, 0, 0, this.width, this.height);
            }
            axios.get('/maps', x, y).then(response => {
                mimage.src = response.data;
                this.drawPlayer(ctx, x, y);
            });
        },

        drawPlayer: function(ctx, x, y) {
            var pimage = new Image();
            pimage.onload = function() {
                //ctx.clearRect(0, 0, this.width, this.height);
                ctx.drawImage(pimage, x, y);
            }
            pimage.src = 'http://torax.outwar.com/images/maptile/YAH.gif';

        },
    },

    mounted() {
        const canvas = this.$refs.mapCanvas;
        const ctx = canvas.getContext('2d');
        this.getX();
        this.getY();
        this.drawMap(ctx, this.x, this.y);
    }
}

</script>

<style>

.elite-map {

}

</style>
