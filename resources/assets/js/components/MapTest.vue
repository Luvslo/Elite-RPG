<template>
    <div class="test-map">
        <canvas id="mapCanvas" ref="mapCanvas" :width="width" :height="height">
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

export default() {

    data() {
        return {
            // canvas
            context: '',
            width: 300,
            height: 300,

            map: [],
            player: [],

            // map
            cols: 10,
            rows: 10,
            layers: [
                {
                    1, 1, 1, 1, 1, 1, 1, 32, 21, 34,
                    1, 1, 1, 1, 1, 1, 1, 44, 21, 46,
                    1, 1, 1, 1, 1, 21, 21, 21, 21, 1,
                    1, 1, 1, 1, 1, 21, 21, 9, 9, 1,
                    1, 1, 21, 21, 21, 21, 21, 1, 1, 1,
                    1, 1, 21, 21, 21, 9, 21, 1, 1, 1,
                    1, 7, 21, 21, 21, 21, 21, 1, 1, 1,
                    2, 33, 21, 22, 22, 21, 20, 1, 1, 1,
                    2, 21, 21, 2, 1, 1, 1, 1, 1, 1,
                    2, 21, 21, 2, 1, 1, 1, 1, 1, 1
                },
                {
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 5, 6, 0,
                    0, 0, 0, 0, 0, 0, 0, 17, 18, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                }],
        },

        methods: {

            createCanvas: function(context) {
                this.context = context;
            },

            createData: function() {
                axios.get('/loadmap').then(response => {
                    this.map = [];
                    this.map.push({
                        src: response.data,
                        cols: 10,
                        rows: 10,
                        tileSize: 32,
                    });
                    this.player = [];
                    this.player.push({
                        src: 'http://i67.tinypic.com/15gblgz.gif',
                        x: 150,
                        y: 150,
                    });
                });
            },

            draw: function() {
                // this.drawMap();
                // this.drawPlayer();
            },

            update: function() {
                // this.updatePlayer();
                // this.updateCamera();
            },

            loop: function() {
                // this.update();
                // this.draw();
                // requestAnimationFrame(this.loop);
            },

            init: function() {
                // this.createData();
                // this.createCamera();
                // this.followCamera();
                // requestAnimationFrame(this.loop);
            },

        },
    },

    mounted() {

        // Canvas init.
        const canvas = this.$refs.mapCanvas;
        const context = canvas.getContext('2d');
        this.createCanvas(context);

        // Game init.
        // this.init();

    }
}

</script>

<style>

.test-map { }

</style>
