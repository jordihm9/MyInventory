'use strict';

$('.burger').click(slideNav);

/**
 * Show or hide burger menu
 */
 function slideNav() {
    // slide nav bar
    $('nav').toggleClass('slide');
    // switch from 3 lines to cross
    $('.burger').toggleClass('cross');
};