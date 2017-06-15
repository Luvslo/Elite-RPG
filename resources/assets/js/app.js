
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component('example', require('./components/Example.vue'));
 Vue.component('chat-message', require('./components/ChatMessage.vue'));
 Vue.component('chat-log', require('./components/ChatLog.vue'));
 Vue.component('chat-compose', require('./components/ChatCompose.vue'));

 /* Elite-RPG Map */
 Vue.component('elite-map', require('./components/Map.vue'));
 //Vue.component('player-move', require('./components/PlayerMove.vue'));

 const app = new Vue({
     el: '#app',

     data: {

         // chat
         items: [],
         usersInRoom: [],

         // world
         direction: '',
         step: '',
         playersInWorld: [],
         speed: 750,
         maps: [],
         x: 150,
         y: 150,
         src: '',
         then: '',
         now: '',

     },

     methods: {

         // Chat send message
         sendMessage: function(item) {
             this.items.push(item);
             axios.post('/messages', item).then(response => {

             });
         },

         playerMove: function(direction, step) {

             if (direction == 'left') {
                 this.x -= this.speed * step
             }
             if (direction == 'right') {
                 this.x += this.speed * step
             }
             if (direction == 'up') {
                 this.y -= this.speed * step
             }
             if (direction == 'down') {
                 this.y += this.speed * step
             }

             // don't let player leaves the world's boundary
             if(this.x - 12 / 2 < 0){
                 this.x = 12 / 2;
             }
             if(this.y - 12 / 2 < 0){
                 this.y = 12 / 2;
             }
             if(this.x + 12 / 2 > this.maps.width){
                 this.x = this.maps.width - 12 / 2;
             }
             if(this.y + 12 / 2 > this.maps.height){
                 this.y = this.maps.height - 12 / 2;
             }

             this.maps = [];
             this.maps.push({
                 src: this.src,
                 x: this.x,
                 y: this.y,
                 width: 384,
                 height: 384,
             });
         },

         loadMap: function() {
             axios.get('/loadmap').then(response => {
                 this.maps = [];
                 this.maps.push({
                     src: response.data,
                     x: this.x,
                     y: this.y,
                     width: 384,
                     height: 384,
                 });
                 this.src = response.data;
             });
         }
     },

     created: function() {

         axios.get('/messages').then(response => {
             this.items = response.data;
         });

         this.loadMap();

         this.then = Date.now();

         Echo.join('eliteworld').here((users) => {
               this.playersInWorld = users;
           }).joining((user) => {
              this.playersInWorld.push(user);
           }).leaving((user) => {
              this.playersInWorld = this.playersInWorld.filter(u => u != user)
           }).listen('PlayerMoving', (e) => {
               var x = this.x;
               var y = this.y;
               this.maps = [];
               this.maps.push({
                   src: e.map.image,
                   x: x,
                   y: y,
               });
               console.log('broadcasing.');
           });




        Echo.join('chatroom')
             .here((users) => {
                 this.usersInRoom = users;
             })
             .joining((user) => {
                 this.usersInRoom.push(user);
             })
             .leaving((user) => {
                 this.usersInRoom = this.usersInRoom.filter(u => u != user)
             })
             .listen('MessagePosted', (e) => {
                 this.items.push({
                     message: e.message.message,
                     user: e.user,
                 });
             });
       },
 });
