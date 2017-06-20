<script>
import Rectangle from './Rectangle.js'
/**
 * Camera -
 * Virtual Viewport for the world map (2D) Canvas - simply the frame
 * of the actual canvas element. -this.x -this.y translates to move
 * the camera as the player moves out of the canvas boundary.
 * @package - Elite-RPG Game
 */
export class Camera {
    /**
     * Constructor - Creates the Camera viewport.
     * @param {Object} map - The map object
     * @param {Number} width - Canvas width
     * @param {Number} height - Canvas height
     */
    constructor(map, width, height) {
        this.x = 0;
        this.y = 0;
        this.width = width;
        this.height = height;
        this.fullWidth = (map.width * map.tileWidth);
        this.fullHeight = (map.height * map.tileHeight);

        // Create a Rectangle for the camera & full size map image
        this.camRect = new Rectangle(this.x, this.y, width, height);
        this.mapRect = new Rectangle(0, 0, this.fullWidth, this.fullHeight);

        // Following object set to false as default.
        this.follow = false;
    }

    /**
     * Create a following object for the camera to use.
     * @param {Object} player - Player object
     */
    onFollow(player) {
        this.follow = player;
        this.maxX = this.width / 2;
        this.maxY = this.width / 2;
    }

    /**
     * Update Camera -
     */
    onUpdate() {

        this.x = Math.max(0, Math.min(this.x, this.maxX));
        this.y = Math.max(0, Math.min(this.y, this.maxY));

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

        this.x = Math.max(0, Math.min(this.x, this.maxX));
        this.y = Math.max(0, Math.min(this.y, this.maxY));

        // set new camera rectangle dimensions -
        // based on the new x&y positions.
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
