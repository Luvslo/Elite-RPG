<template>
    <div class="test-map" :images="images">
        <div>
            <strong>Elite RPG Map Test</strong>
        </div>
        <canvas id="testCanvas" ref="testCanvas" :width="width" :height="height"></canvas>
    </div>

</template>

<script>

/**
 * Rough Draft for Canvas tile map.
 *
 * @author <theHeadTy - theheadty@gmail.com>
 * @package Elite-RPG
 */

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
            tileAtlas: '',
            playerAtlas: '',
        }
    },

    methods: {

        /**
         * Loads asset images, tiles (spritesheet) and players (red dot)
         * @param {array} arr - Returned array from createAssets
         */
        loadImages: function(arr) {
            for (var i = 0; i < arr.length; i++) {
                let image = new Image();
                let loaded = image;
                if (loaded) {
                    image.src = arr[i]['image'];
                    this.images.push({
                        key: arr[i]['key'],
                        image: loaded
                    });
                }
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
            //return this.map;
        },

        /**
         * Constructor for player[]
         */
        createPlayer: function() {
            this.player = {
                src: 'http://i67.tinypic.com/15gblgz.gif',
                x: 150,
                y: 150,
            };
        },

        /**
         * Asset array - Store for the asset images that are
         * going to be pre-loaded.
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
         * @param {string} val - key to search for from the images array.
         * @return {array} image
         */
        createAtlas: function(val) {
            return this.images.find((arr) => {
                return arr.key === val;
            })['image'];
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
         * @param {number} mapW
         * @param {number} mapH
         * @param {number} tileH
         * @param {number} tileSize
         */
        renderMap(mapW, mapH, tileW, tileH, tileSize) {

            var ctx = this.context;

            for (let w = 0; w < mapW; w++) {
                for (let h = 0; h < mapH; h++) {

                    let tile = this.layers[w][h];

                    let xpos = w * tileSize;
                    let ypos = h * tileSize;

                    let x = tile % mapW;
                    let y = Math.floor(tile / mapH);

                    let sx = x * tileW;
                    let sy = y * tileH;

                    ctx.drawImage(
                        this.tileAtlas,
                        sx, sy,
                        tileSize, tileSize,
                        xpos, ypos,
                        tileSize, tileSize
                    );
                }
            }
        },

        /**
         * Renders the map & player
         * @todo - Create a createPlayer() & renderPlayer() method.
         */
        renderGame: function() {
            this.createStage();
        },

        /**
         * Animation loop - Updates & Renders.
         * @param {string} timestamp
         */
        loopGame: function(timestamp) {
            this.context.clearRect(0, 0, this.width, this.height);
            this.renderGame();
        },

        /**
         * Initiate Game - Creates, Loads & Instantiates animation loop.
         * @param {HTMLCanvasElement} context
         */
        initGame(context) {
            this.createCanvas(context);
            this.createMap();
            this.createPlayer();
            this.loadImages(this.createAssets());
            this.loopGame();
        }
    },

    /**
     * Creates canvas & context.
     * HTMLCanvasElement
     * HTMLCanvasElement.getContext
     * @this.initGame(HTMLCanvasElement.getContext);
     */
    mounted() {
        const canvas = this.$refs.testCanvas;
        const ctx = canvas.getContext('2d');

        this.initGame(ctx);
    },

    // TODO: @keyup @keydown
    created() {
        //addEventListener('keyup', this.update);
        //addEventListener('keydown', this.update);
    },
}

</script>

<style>

.test-map { }

</style>
