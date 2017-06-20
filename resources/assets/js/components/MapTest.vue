<script src="https://cdnjs.cloudflare.com/ajax/libs/tween.js/16.3.5/Tween.min.js"></script>
<template>
    <div class="test-map">
        <div>
            <strong>Elite RPG Map Test</strong>
        </div>
        <canvas id="testCanvas" ref="testCanvas" :width="width" :height="height"></canvas>
    </div>

</template>

<script>

/**
 * Elite-RPG Map - Rough Draft HTMLCanvasElement Tile Map.
 *
 * @author <theHeadTy - theheadty@gmail.com>
 * @package Elite-RPG
 * @version 1.2
 */

import Camera from './world/Camera.vue'

export default {

    data() {
        return {
            // canvas
            context: '',
            width: 300,
            height: 300,

            map: [],
            player: [],

            layers: [
                [55, 55, 55, 55, 55, 55, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                [55, 55, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                [55, 55, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                [55, 55, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                [55, 55, 21, 21, 21, 21, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 55, 55, 55, 55, 55, 55],
                [55, 55, 21, 21, 21, 21, 1, 1, 55, 55, 1, 1],
                [55, 55, 21, 21, 21, 21, 1, 1, 1, 1, 1, 1]
            ],

            images: [],
            tileAtlas: null,
            playerAtlas: null,

            // Delta time
            speed: 256,
            then: 0,
            now: 0,
            delta: 0,

        }
    },

    methods: {

        /**
         * Loads asset images -
         * tiles (spritesheet) & players (red dot)
         * @param {array} arr - createAssets Array.
         */
        loadImages: function(arr) {
            for (var i = 0; i < arr.length; i++) {
                var image = new Image();
                image.onload = function() { }
                let loaded = image;
                image.src = arr[i]['image'];
                this.images.push({
                    key: arr[i]['key'],
                    image: loaded
                });
            }
        },

        /**
         * Creates the data for context.
         * @param {HTMLCanvasElement.getContext} context
         */
        createCanvas: function(context) {
            this.context = context;
        },

        /**
         * Constructor for map[]
         */
        createMap: function() {
            this.map = {
                width: 12,
                height: 12,
                tileWidth: 32,
                tileHeight: 32,
                src: 'https://i.imgur.com/FWftOoT.png',
            };
        },

        /**
         * Constructor for player[]
         */
        createPlayer: function() {
            this.player = {
                src: 'http://i67.tinypic.com/15gblgz.gif',
                x: 150,
                y: 150,
                width: 32,
                height: 32
            };
        },

        /**
         * Creates Asset array -
         * Store for all asset images that need to be pre-loaded.
         * @return {array}
         */
        createAssets: function() {
            return [
                {key: 'tiles', image: this.map.src},
                {key: 'player', image: this.player.src}
            ];
        },

        /**
         * Creates the atlas for player & tile map.
         * @param {string} val - Key to search for from the images array.
         * @return {array}
         */
        createAtlas: function(val) {
            return this.images.find((arr) => {
                return arr.key === val;
            })['image'];
        },

        /**
         * Clamp players min/max x & y coordinates.
         * @param {Number} x - Players current x (getting updated)
         * @param {Number} y - Players current y (getting updated)
         */
        clampPlayer: function(x, y) {

            let width = this.player.width;
            let height = this.player.height;

            let maxX = this.map.width * this.map.tileWidth;
            let maxY = this.map.height * this.map.tileHeight + 2;

            this.player.x = Math.max(0, Math.min(x, maxX));
            this.player.y = Math.max(0, Math.min(y, maxY));
        },

        /**
         * Update players x & y position.
         * @param {KeyboardEvent} e - Event
         */
        updatePlayer: function(e) {
            if (e.keyCode === 37) {
                this.player.x -= this.speed * this.delta;
            }
            if (e.keyCode === 39) {
                this.player.x += this.speed * this.delta;
            }
            if (e.keyCode === 38) {
                this.player.y -= this.speed * this.delta;
            }
            if (e.keyCode === 40) {
                this.player.y += this.speed * this.delta;
            }
            this.clampPlayer(this.player.x, this.player.y);
        },

        /**
         * Constructs & renders the map onto HTMLCanvasElement.
         */
        createStage: function() {
            this.tileAtlas = this.createAtlas('tiles');
            var mapW = this.map.width;
            var mapH = this.map.height;
            var tileW = this.map.tileWidth;
            var tileH = this.map.tileHeight;
            var tileSize = (tileW + tileH) / 2;
            var width = this.width / tileW;
            var height = this.height / tileH;
            this.renderMap(mapW, mapH, tileH, tileW, tileSize);
        },

        /**
         * Render - Draw onto HTMLCanvasElement
         * @param {Number} mapW
         * @param {Number} mapH
         * @param {Number} tileH
         * @param {Number} tileSize
         */
        renderMap(mapW, mapH, tileWidth, tileHeight, tileSize) {

            var cameraX = Math.floor(Camera.x / tileWidth);
            var cameraY = Math.floor(Camera.y / tileHeight);
            var offsetX = -Camera.x + cameraX * tileWidth;
            var offsetY = -Camera.y + cameraY * tileHeight;

            var ctx = this.context;

            for (let w = 0; w < mapW; w++) {
                for (let h = 0; h < mapH; h++) {

                    let tile = this.layers[w][h];

                    let xpos = w * tileSize;
                    let ypos = h * tileSize;

                    //let xpos = (w - cameraX) * tileWidth + offsetX;
                    //let ypos = (h - cameraY) * tileHeight + offsetY;

                    // dont modify --
                    let x = tile % mapW;
                    let y = Math.floor(tile / mapH);

                    let sx = x * tileWidth;
                    let sy = y * tileHeight;
                    // end dont modify --

                    ctx.save();
                    ctx.translate(-Camera.x, -Camera.y);
                    ctx.drawImage(
                        this.tileAtlas,
                        sx, sy,
                        tileWidth, tileHeight,
                        xpos, ypos,
                        tileWidth, tileHeight,
                    );
                    ctx.restore();
                }
            }
        },

        /**
         * Render Player -
         * Draws player onto {HTMLCanvasElement.getContext}
         * @todo - x&y need to have their image (w&h / 2) when defined.
         * @example - let xpos = (player.x - (image.width / 2) - camera.x)
         * Without that defined the clamp values are not entirely accurate.
         * Once I have player sprite sheets, and a default image to use
         * then I will be able to compute sizes, and create a function
         * for that - But until then the bootleg red dot works.
         */
        renderPlayer: function() {
            this.playerAtlas = this.createAtlas('player');
            let ctx = this.context;

            //let xpos = this.player.x - Camera.x; // @todo (image.width / 2)
            //let ypos = this.player.y - Camera.y; // @todo (image.height / 2)

            let xpos = (this.player.x - (this.player.width / 2) - Camera.x);
            let ypos = (this.player.y - (this.player.height / 2) - Camera.y);

            let width = (this.player.width / 2);
            let height = (this.player.height / 2);

            ctx.save();
            ctx.fillStyle = 'red';
            ctx.fillRect(xpos, ypos, width, height);
            ctx.restore();

            // Draw player on the world!
            //ctx.drawImage(this.playerAtlas, xpos, ypos);
        },

        /**
         * Renders the map & player
         * @todo - Create renderPlayer() method.
         */
        renderGame: function() {
            this.context.clearRect(0, 0, this.width, this.height);
            this.createStage();
            this.renderPlayer();
        },

        updateGame: function() {
            Camera.onUpdate();
        },

        /**
         * Animation loop - Updates & Renders.
         * @param {string} timestamp - timestamp for animation.
         */
        loopGame: function(timestamp) {

            this.now = timestamp;
            this.delta = (timestamp - this.then) / 1000.0;
            this.delta = Math.min(this.delta, 0.25);
            this.then = this.now;

            this.updateGame();
            this.renderGame();
            requestAnimationFrame(this.loopGame);
        },

        /**
         * Initiate Game - Creates, Loads & Instantiates animation loop.
         * @param {HTMLCanvasElement.getContext} context
         * @param
         */
        initGame(context) {
            this.createCanvas(context);
            this.createMap();
            this.createPlayer();

            Camera.Camera(this.map, this.width, this.height);
            Camera.onFollow(this.player);

            this.loadImages(this.createAssets());
            requestAnimationFrame(this.loopGame);
        }
    },

    /**
     * Creates canvas & context.
     * {HTMLCanvasElement}
     * {HTMLCanvasElement.getContext}
     * @this.initGame(HTMLCanvasElement.getContext);
     * @todo - Add a Promise for loading assets.
     */
    mounted() {
        const canvas = this.$refs.testCanvas;
        const ctx = canvas.getContext('2d');
        this.initGame(ctx);
    },

    // @note - Testing key events, just for debugging to move around.
    // eventually this will owm its own component.
    created() {
        addEventListener('keyup', this.updatePlayer);
        addEventListener('keydown', this.updatePlayer);
    },
}

</script>

<style>

.test-map { }

</style>
