/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// FICHIERS CSS A CHARGER
require('../css/app.css');

// FICHIER JS A CHARGER

// Affichage de formulaire pour contacter l'agence
require('../js/formContact.js');
// Suppression des images dans le formulaire de modif d'un bien dans l'administration
require('../js/deletePicture.js');





/*
// Jquery utile pour la lib select2
var $ = require('jquery');
// any CSS you import will output into a single css file (app.css in this case)
require('../css/app.css');


// Librairie js qui permet d'améliorer le comportement des boutons select
require('select2');
// En jquery on selectionne tout les boutons select et on applique notre select2
$('select').select2();
*/

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
