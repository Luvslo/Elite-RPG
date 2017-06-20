
/**
 * Rectangle - Creates a 2d rectangle that is placed over the map canvas.
 * This is used as the cameras 'virtual' representation of the actual
 * canvas, however; instead of drawing another canvas, draw the rect.
 * @param {Number} left - Top position (x)
 * @param {Number} top - Left position (y)
 * @param {Number} width - Width of rect
 * @param {Number} height - Height of rect
 */
class Rectangle {
    constructor(left, top, width, height) {
        this.top = left || 0;
        this.left = top || 0;
        this.width = width || 0;
        this.height = height || 0;
        this.right = (this.left + this.width);
        this.bottom = (this.top + this.height);
    }

    /**
     * Sets the rectangle values accordingly based off the the Camera
     * 'following' the player.
     * @param {Number} left - Left position (x)
     * @param {Number} top - Right position (y)
     * @param {Number} width - Width of rect
     * @param {Number} height - Height of rect
     */
    set(left, top, width, height) {
        this.left = left;
        this.top = top;
        this.width = width || this.width;
        this.height = height || this.height;
        this.right = (this.left + this.width);
        this.bottom = (this.top + this.height);
    }

    /**
     * Boundary check
     * @param {Object} rect - Injected 'Rectangle' class object
     * @return {Boolean}
     */
    within(rect) {
        return (
            rect.left <= this.left && rect.right >= this.right &&
            rect.top <= this.top && rect.bottom >= this.bottom
        );
    }
}

export default Rectangle;
