/**
* Fonction de suivi des clics sur des liens sortants dans Analytics
* Cette fonction utilise une chaîne d'URL valide comme argument et se sert de cette chaîne d'URL
* comme libellé d'événement. Configurer la méthode de transport sur 'beacon' permet d'envoyer le clic
* au moyen de 'navigator.sendBeacon' dans les navigateurs compatibles.
*/
var trackOutboundLink = function(url) {
   ga('send', 'event', 'outbound', 'click', url, {
     'transport': 'beacon',
     'hitCallback': function(){document.location = url;}
   });
}
