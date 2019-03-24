
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery');
require('daterangepicker');



window.Chart = require('chart.js');


$(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
});
