<template>
    <div class="elite-map">
        <canvas ref="mapCanvas" :width="300" :height="300"></canvas>
        X: {{ this.map.x }} - Y: {{ this.map.y }}
    </div>
</template>
<script>


/**
 * Elite-RPG Explore
 * @author <theHeadTy - Ty.S>
 *
 * @todo - Right now the map is only a single image. I would like to
 * switch to the regular 'tile' format using a JSON file with the
 * map image coordinates. That will allow for easy pathfinding, collision,
 * NPC placement, and to add new worlds to the game...
 *
 */
export default {

    props: ['map'],

    data() {
        return {
            // canvas
            src: '',
            ctx: '',
            speed: 356,
            maps: [],
            width: 300,
            height: 300,

            moving: false,

            // player
            pwidth: 12,
            pheight: 12,

            // camera
            camX: 0,
            camY: 0,
            maxX: 0,
            maxY: 0,
            following: null,
            screenX: 0,
            screenY: 0,

            // delta
            now: 0,
            last: 0,
            step: 0,
        }
    },

    computed: {
        mapData: function() {
            return this.map;
        },
    },

    methods: {

        cameraCreate: function() {
            this.camX = 0;
            this.camY = 0;
            this.maxX = this.map.width - this.width;
            this.maxY = this.map.height - this.height;
        },

        cameraFollow: function(map) {
            this.following = map;
            this.screenX = 0;
            this.screenY = 0;
        },

        cameraUpdate: function() {

            this.screenX = this.width / 2;
            this.screenY = this.height / 2;

            this.camX = this.following.x - this.width / 2;
            this.camY = this.following.y - this.height / 2;

            // clamp values
            this.camX = Math.max(0, Math.min(this.camX, this.maxX));
            this.camY = Math.max(0, Math.min(this.camY, this.maxY));


            if (this.following.x < this.width / 2 ||
                this.following.x > this.maxX + this.width / 2) {
                this.screenX = this.following.x - this.camX;
            }

            if (this.following.y < this.height / 2 ||
                this.following.y > this.maxY + this.height / 2) {
                this.screenY = this.following.y - this.camY;
            }
        },

        previous: function (e) {

            var dirx = 0;
            var diry = 0;

            if (e.keyCode == 37) {
                dirx = -1;
                this.map.x += dirx * this.speed * this.step;
            }
            if (e.keyCode == 39) {
                dirx = 1;
                this.map.x += dirx * this.speed * this.step;
            }
            if (e.keyCode == 38) {
                diry = -1;
                this.map.y += diry * this.speed * this.step;
            }
            if (e.keyCode == 40) {
                diry = 1;
                this.map.y += diry * this.speed * this.step;
            }

            // clamp values
            var maxX = this.map.width - this.pwidth / 2;
            var maxY = this.map.height - this.pheight / 2;
            this.map.x = Math.max(0, Math.min(this.map.x, maxX));
            this.map.y = Math.max(0, Math.min(this.map.y, maxY));

            this.map.x = Math.ceil(this.map.x);
            this.map.y = Math.ceil(this.map.y);

        },

        createCanvas: function(context) {
            return this.ctx = context;
        },

        drawMap: function() {
            var ctx = this.ctx;
            var image = new Image();
            image.src = this.map.src;

            var x = this.camX;
            var y = this.camY;

            image.onload = function() {
                ctx.drawImage(image, x, y, this.width, this.height, 0, 0, this.width, this.height);
            }
        },

        drawPlayer: function() {
            var ctx = this.ctx;
            var pimage = new Image();
            //pimage.src = 'http://torax.outwar.com/images/maptile/YAH.gif';
            pimage.src = 'https://www.dropbox.com/home?preview=YAH.gif';

            var x = this.screenX - this.pwidth / 2;
            var y = this.screenY - this.pheight / 2;

            pimage.onload = function() {
                ctx.drawImage(pimage, x, y);
            }
        },

        drawAll: function() {
            var ctx = this.ctx;
            ctx.clearRect(0, 0, this.width, this.height);
            this.drawMap();
            this.drawPlayer();
        },

        gameLoop: function(timestamp) {
            window.requestAnimationFrame(this.gameLoop);
            this.now = timestamp;
            this.step = (this.now - this.last) / 1000.0;
            //this.step = Math.min(this.step, 0.25);
            this.last = this.now;
            this.previous;
            this.cameraUpdate();
            this.drawAll();
            //requestAnimationFrame(this.gameLoop);
        }

    },

    created: function() {
        window.addEventListener('keyup', this.previous);
        window.addEventListener('keydown', this.previous);
    },

    mounted() {

        var canvas = this.$refs.mapCanvas;
        var ctx = canvas.getContext('2d');

        this.createCanvas(ctx);
        this.cameraCreate();
        this.cameraFollow(this.mapData);
        window.requestAnimationFrame(this.gameLoop);
    },

}

</script>

<style>

.elite-map {

}

</style>
