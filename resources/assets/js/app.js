/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


$('.visibility-cart').on('click', function() {

    var $btn = $(this);
    var $cart = $('.cart');
    console.log($btn);

    if ($btn.hasClass('is-open')) {
        $btn.removeClass('is-open');
        $btn.text('O')
        $cart.removeClass('is-open');
        $cart.addClass('is-closed');
        $btn.addClass('is-closed');
    } else {
        $btn.addClass('is-open');
        $btn.text('X')
        $cart.addClass('is-open');
        $cart.removeClass('is-closed');
        $btn.removeClass('is-closed');
    }


});

// SHOPPING CART PLUS OR MINUS
$('a.qty-minus').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if (value > 1) {
        value = value - 1;
    } else {
        value = 0;
    }

    $input.val(value);

});

$('a.qty-plus').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if (value < 100) {
        value = value + 1;
    } else {
        value = 100;
    }

    $input.val(value);
});

// RESTRICT INPUTS TO NUMBERS ONLY WITH A MIN OF 0 AND A MAX 100
$('input').on('blur', function() {

    var input = $(this);
    var value = parseInt($(this).val());

    if (value < 0 || isNaN(value)) {
        input.val(0);
    } else if (value > 100) {
        input.val(100);
    }
});