/*
    GESTION DE L'APPARITION DU FORMULAIRE DE CONTACT DE L'AGENCE (Jquery) dans proprety/show.html.twig
*/

// On signifie que le "$" est du Jquery
let $ = require('jquery');
// On charge "select2" (librairie js qui gère le style des bouton select, et on l'active en jquery)
require('select2');
$('select').select2();

let $contactButton = $('#contactButton');
$contactButton.click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
});