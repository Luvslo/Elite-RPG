
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
 Vue.component('player-move', require('./components/PlayerMove.vue'));

 const app = new Vue({
     el: '#app',

     data: {

         // chat
         items: [],
         usersInRoom: [],

         // world
         direction: '',
         playersInWorld: [],
         speed: 5,
         maps: [],

     },

     methods: {

         // Chat send message
         sendMessage: function(item) {
             this.items.push(item);
             axios.post('/messages', item).then(response => {

             });
         },

         playerMove: function(direction) {
             if (direction == 'left') {
                 this.x -= this.speed;
             }
             if (direction == 'right') {
                 this.y += this.speed;
             }
             if (direction == 'up') {
                 this.y -= this.speed;
             }
             if (direction == 'down') {
                 this.y += this.speed;
             }

         },

     },

     created: function() {

         axios.get('/messages').then(response => {
             this.items = response.data;
         });

         axios.get('/loadmap').then(response => {
             this.maps.push({
                 src: response.data,
                 x: 150,
                 y: 150,
             });
         });

         Echo.join('elite-world').here((users) => {
             this.playersInWorld = users;
         }).joining((user) => {
            this.playersInWorld.push(user);
         }).leaving((user) => {
            this.playersInWorld = this.playersInWorld.filter(u => u != user)
         }).listen('PlayerMoving', (e) => {
             this.src = e.map.src;
             this.x = this.x;
             this.y = this.y;
             console.log('Map loading.');
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
