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
 * Rough Draft for the way I am working towards.
 *
 * I want to use MONGO DB to store each maps JSON file (cols, rows, layers, ect)
 * and when the page loads (ill use axios first) to pull the players/maps data.
 *
 * Eventually I will create a socket connection to pull data that way -
 * interactive PVP battles!
 */

export default {

    data() {
        return {
            // canvas
            context: '',
            width: 300,
            height: 300,

            maps: [],
            players: [],
            camera: [],

            layers: [[
                3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3,
                3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 3,
                3, 1, 2, 2, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 2, 2, 1, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 3,
                3, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 3,
                3, 3, 3, 1, 1, 2, 3, 3, 3, 3, 3, 3
            ], [
                4, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 5, 0, 0, 0, 0, 0, 5, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4,
                4, 4, 4, 0, 5, 4, 4, 4, 4, 4, 4, 4,
                4, 4, 4, 0, 0, 3, 3, 3, 3, 3, 3, 3
            ]],

            following: '',
            screenX: 0,
            screenY: 0,
            viewX: 0,
            viewY: 0,

            now: 0,
            last: 0,
            delta: 0,
            speed: 256,

        }
    },

    methods: {

        createCanvas: function(context) {
            this.context = context;
        },

        createData: function() {
            this.maps = {
                src: 'http://mozdevs.github.io/gamedev-js-tiles/assets/tiles.png',
                cols: 12,
                rows: 12,
                tsize: 64,
            };

            var x = (this.maps.cols * this.maps.tsize / 2) - (this.maps.tsize / 2);
            var y = (this.maps.rows * this.maps.tsize / 2) - (this.maps.tsize / 2);

            this.players = {
                src: 'http://i67.tinypic.com/15gblgz.gif',
                x: x,
                y: y,
                viewY: 0,
                viewX: 0,
                speed: 300,
            };
        },

        createCamera: function() {
            this.camera = {
                x: 0,
                y: 0,
                width: this.width,
                height: this.height,
                maxX: this.maps.cols * this.maps.tsize - this.width,
                maxY: this.maps.rows * this.maps.tsize - this.height,
            };
        },

        followCamera: function(player) {
            this.following = player;
            this.viewX = 0;
            this.viewY = 0;
        },

        updateCamera: function() {

            //this.screenX = this.camera.width / 2;
            //this.screenY = this.camera.height / 2;

            this.viewX = this.width / 2;
            this.viewY = this.height / 2;

            this.camera.x = this.following.x - this.camera.width / 2;
            this.camera.y = this.following.y - this.camera.height / 2;

            this.camera.x = Math.max(0, Math.min(this.camera.x, this.camera.maxX));
            this.camera.y = Math.max(0, Math.min(this.camera.y, this.camera.maxY));

            if (this.following.x < this.camera.width / 2 ||
                this.following.x > this.maxX + this.camera.width / 2) {
                this.viewX = this.following.x - this.camera.x;
            }
            if (this.following.y < this.camera.height / 2 ||
                this.following.y > this.maxY + this.camera.height / 2) {
                this.viewY = this.following.y - this.camera.y;
            }
        },

        getTile: function (layer, col, row) {
            return this.layers[layer][row * this.maps.cols + col];
        },

        drawGrid: function() {
            var x, y;
            var ctx = this.context;
            var width = this.maps.cols * this.maps.tsize;
            var height = this.maps.rows * this.maps.tsize;
            for (var r = 0; r < this.maps.rows; r++) {
                x = - this.camera.x;
                y = r * this.maps.tsize - this.camera.y;
                ctx.beginPath();
                ctx.moveTo(x, y);
                ctx.lineTo(width, y);
                ctx.stroke();
            }
            for (var c = 0; c < this.maps.cols; c++) {
                x = c * this.maps.tsize - this.camera.x;
                y = - this.camera.y;
                ctx.beginPath();
                ctx.moveTo(x, y);
                ctx.lineTo(x, height);
                ctx.stroke();
            }
        },

        drawMap: function(layer) {

            var ctx = this.context;
            var tsize = this.maps.tsize;
            var image = new Image();

            // TODO: put this into a function ->
            var startCol = Math.floor(this.camera.x / tsize);
            var endCol = startCol + (this.camera.width / tsize);
            var startRow = Math.floor(this.camera.y / tsize);
            var endRow = startRow + (this.camera.height / tsize);
            var offsetX = -this.camera.x + startCol * tsize;
            var offsetY = -this.camera.y + startRow * tsize;

            for (var c = startCol; c <= endCol; c++) {
                for (var r = startRow; r <= endRow; r++) {
                    var tile = this.getTile(layer, c, r);
                    var x = (c - startCol) * tsize + offsetX;
                    var y = (r - startRow) * tsize + offsetY;
                    if (tile != 0) {
                        ctx.drawImage(
                            image,
                            (tile - 1) * tsize, 0,
                            tsize, tsize,
                            Math.round(x), Math.round(y),
                            tsize, tsize
                        );
                        image.src = this.maps.src;
                    }
                }
            }
        },

        drawPlayer: function() {
            var ctx = this.context;
            var pimage = new Image();

            var x = this.viewX - this.maps.tsize / 2;
            var y = this.viewY - this.maps.tsize / 2;

            pimage.onload = function() {
                ctx.drawImage(pimage, x, y);
            }
            pimage.src = this.players.src;
        },

        updatePlayer: function(e) {
            if (e) {
                if (e.keyCode === 37) {
                    //console.log('moving left..');
                    this.players.x -= this.speed * this.delta;
                }
                if (e.keyCode === 39) {
                    //console.log('moving right');
                    this.players.x += this.speed * this.delta;
                }
                if (e.keyCode === 38) {
                    //console.log('moving up');
                    this.players.y -= this.speed * this.delta;
                }
                if (e.keyCode === 40) {
                    //console.log('moving down');
                    this.players.y += this.speed * this.delta;
                }
            }
            // clamp values.
            var maxX = this.maps.cols * this.maps.tsize;
            var maxY = this.maps.rows * this.maps.tsize;
            this.players.x = Math.max(0, Math.min(this.players.x, maxX));
            this.players.y = Math.max(0, Math.min(this.players.y, maxY));

            console.log('player x: ' + this.players.x);
        },

        drawGame: function() {
            var ctx = this.context;
            ctx.clearRect(0, 0, this.width, this.height);
            this.drawMap(0);
            this.drawMap(1);
            this.drawPlayer();
            //this.drawGrid();
        },

        updateGame: function() {
            this.updatePlayer();
            this.updateCamera();
        },

        animateGame: function(timestamp) {
            this.now = timestamp;
            this.delta = (this.now - this.last) / 1000.0;
            this.delta = Math.min(this.delta, 0.25);
            this.last = this.now;

            // Update player & camera
            this.updateGame();

            // Draw map & player
            this.drawGame();

            // Animate (loop)
            requestAnimationFrame(this.animateGame);
        },

        initGame: function() {
            // Create map & player array
            this.createData();

            // Set up the camera
            this.createCamera();
            this.followCamera(this.players);

            // Game animation loop.
            requestAnimationFrame(this.animateGame);
        },

    },

    created: function() {
        addEventListener('keyup', this.updatePlayer);
        addEventListener('keydown', this.updatePlayer);
    },

    mounted() {
        // Canvas init.
        const canvas = this.$refs.testCanvas;
        const context = canvas.getContext('2d');
        this.createCanvas(context);

        this.initGame();
    }
}

</script>

<style>

.test-map { }

</style>
