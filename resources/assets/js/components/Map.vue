<template>
    <div class="elite-map">
        <div class="col-md-6">
            <strong>Room Name: {{ map.name }}</strong>
            <!-- Map Component -->
            <canvas ref="mapCanvas" :width="width" :height="height"></canvas>
            <div>
                <small>X: {{ map.x }} - Y: {{ map.y }}</small>
            </div>
        </div>
        <!--<elite-mobs></elite-mobs>-->
    </div>
</template>


<script>
/**
 * Elite-RPG <Map>
 * @author - <theHeadTy - Ty.S>
 *
 * @props map
 * @data -
 */
export default {

    props: ['map'],

    data() {
        return {
            // canvas
            src: '',
            ctx: '',
            maps: [],
            width: 300,
            height: 300,

            // player
            pwidth: 10,
            pheight: 10,
            speed: 256,

            // camera
            camX: 0,
            camY: 0,
            maxX: 0,
            maxY: 0,
            following: null,
            screenX: 0,
            screenY: 0,

            // animation config
            then: 0,
            now: 0,
            delta: 0,

            // NPC
            roomName: '',
        }
    },

    computed: {
        mapData: function() {
            return this.map;
        },
        roomData: function() {
            return this.roomName;
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

        updatePlayer: function (e) {

            if (e) {
            if (e.keyCode === 37) {
                this.map.x -= this.speed * this.delta;
                //this.map.x -= 3;
            }
            if (e.keyCode === 39) {
                this.map.x += this.speed * this.delta;
                //this.map.x += 3;
            }
            if (e.keyCode === 38) {
                this.map.y -= this.speed * this.delta;
                //this.map.y -= 3;
            }
            if (e.keyCode === 40) {
                this.map.y += this.speed * this.delta;
                //this.map.y += 3;
            }
        }

            // clamp values
            var maxX = this.map.width - (this.pwidth / 2);
            var maxY = this.map.height - (this.pheight / 2);

            this.map.x = Math.max(0, Math.min(this.map.x, maxX));
            this.map.y = Math.max(0, Math.min(this.map.y, maxY));

            this.map.x = Math.round(this.map.x);
            this.map.y = Math.round(this.map.y);

            //this.$emit('send', this.map.x, this.map.y);
            //axios.get('/maps').then(response => {
                // should be broadcasting the websocket event!?
            //});
            if (e) {
                this.$emit('send', this.map);
            }
        },

        createCanvas: function(context) {
            return this.ctx = context;
        },

        drawMap: function(layer) {
            var ctx = this.ctx;
            var image = new Image();
            var x = this.camX;
            var y = this.camY;
            image.onload = function() {
                ctx.drawImage(image, x, y, this.width, this.height, 0, 0, this.width, this.height);
            }
            image.src = this.map.src;
        },

        drawPlayer: function() {
            var ctx = this.ctx;
            var pimage = new Image();
            pimage.src = 'http://i67.tinypic.com/15gblgz.gif';
            var x = this.screenX - this.pwidth / 2;
            var y = this.screenY - this.pheight / 2;
            pimage.onload = function() {
                ctx.drawImage(pimage, x, y, pimage.width, pimage.height);
            }
        },

        drawGame: function() {
            var ctx = this.ctx;
            ctx.clearRect(0, 0, this.width, this.height);
            this.drawMap();
            this.drawPlayer();
        },


        updateGame: function() {
            this.updatePlayer();
            this.cameraUpdate();
        },

        loopGame: function(timestamp) {
            this.now = timestamp;
            this.delta = (this.now - this.then) / 1000.0;
            this.delta = Math.min(this.delta, 0.50);
            this.then = this.now;
            this.updateGame();
            this.drawGame();
            requestAnimationFrame(this.loopGame);
        },

        initGame: function(context) {
            this.createCanvas(context);
            this.cameraCreate();
            this.cameraFollow(this.mapData);
            requestAnimationFrame(this.loopGame);
        },

        /*gameLoop: function(timestamp) {

            this.now = timestamp;
            this.delta = (this.now - this.then) / 1000.0;
            //this.delta = Math.min(this.delta, 0.25);
            this.then = this.now;

            requestAnimationFrame(this.gameLoop);

            //this.updatePlayer;
            //this.cameraUpdate();
            this.drawAll();
            //requestAnimationFrame(this.gameLoop);
        },*/
    },

    created() {

        addEventListener('keyup', this.updatePlayer);
        addEventListener('keydown', this.updatePlayer);

        // Elite-RPG World Websocket listen.
        Echo.join('eliteworld').listen('PlayerMoving', (e) => {
            this.roomName = e.map.name;
            console.log('room name: ' + this.roomName);
        });

    },

    mounted() {

        const canvas = this.$refs.mapCanvas;
        const ctx = canvas.getContext('2d');

        /*this.createCanvas(ctx);
        this.cameraCreate();
        this.cameraFollow(this.mapData);
        requestAnimationFrame(this.gameLoop);
        */

        this.initGame(ctx);

    },
}

</script>

<style>

.elite-map {

}

</style>
