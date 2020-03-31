/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('prof-edit', require('./components/profEdit.vue').default);
Vue.component('step-register', require('./components/stepRegister.vue').default);
Vue.component('step-list', require('./components/stepList.vue').default);
Vue.component('parent-detail', require('./components/parentDetail/parentDetail.vue').default);
Vue.component('child-detail', require('./components/childDetail.vue').default);
Vue.component('mypage', require('./components/mypage/mypage.vue').default);
Vue.component('index', require('./components/index/index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

// フラッシュメッセージ
$(function(){
    var $jsToggleMsg = $('#js-toggle-msg');
    var msg = $jsToggleMsg.text();
    if(msg.replace(/^[\s　]+|[\s　]+$/g, "").length){
      $jsToggleMsg.slideDown('slow');
      setTimeout(function(){ $jsToggleMsg.slideUp('slow'); }, 5000);
    }

    // ハンバーガーメニュー
    $('.js-toggle-sp-menu').on('click', function(){
        $(this).toggleClass('active');
        $('.js-toggle-sp-target').toggleClass('active');
    });
    $('.menu-link').on('click', function(){
        $('.js-toggle-sp-menu').toggleClass('active');
        $('.js-toggle-sp-target').toggleClass('active');
    });
})