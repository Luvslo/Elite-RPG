<script>

import Rectangle from './Rectangle.js'

//export default class Camera ({
export default {

    /**
     * Constructor - Creates the Camera viewport.
     * @param {Object} map - The map object
     * @param {Number} width - Canvas width
     * @param {Number} height - Canvas height
     */
    Camera: function(map, width, height) {
        this.x = 0;
        this.y = 0;
        this.width = width;
        this.height = height;
        this.fullWidth = (map.width * map.tileWidth);
        this.fullHeight = (map.height * map.tileHeight);

        // Create a Rectangle for the camera & full map
        this.camRect = new Rectangle(this.x, this.y, width, height);
        this.mapRect = new Rectangle(0, 0, this.fullWidth, this.fullHeight);
        this.follow = false;

        //this.maxCamX = this.map.width * this.map.tileWidth - width;
        //this.maxCamY = this.map.height * this.map.tileHeight - height;


    },

    /**
     * Instantiates the camera to 'follow'
     * @param {Object} player - Player object
     */
    onFollow: function(player) {
        this.follow = player;
        this.maxX = this.width / 2;
        this.maxY = this.width / 2;
    },


    /**
     * Updates the camera
     */
    onUpdate: function() {

        if (this.follow.x - this.x + this.maxX > this.width) {
            this.x = this.follow.x - (this.width - this.maxX);
        } else if (this.follow.x - this.maxX < this.x) {
            this.x = this.follow.x - this.maxX;
        }

        if (this.follow.y - this.y + this.maxY > this.height) {
            this.y = this.follow.y - (this.height - this.maxY);
        } else if (this.follow.y - this.maxY < this.height) {
            this.y = this.follow.y - this.maxY;
        }

        // Set the updated camera settings into the camera rectangle.
        this.camRect.set(this.x, this.y);

        if(!this.camRect.within(this.mapRect)) {
            if (this.camRect.left < this.mapRect.left)
                this.x = this.mapRect.left;

            if (this.camRect.top < this.mapRect.top)
                this.y = this.mapRect.top;

            if (this.camRect.right > this.mapRect.right)
                this.x = this.mapRect.right - this.width;

            if (this.camRect.bottom > this.mapRect.bottom)
                this.y = this.mapRect.bottom - this.height;
        }
    }


}
</script>
