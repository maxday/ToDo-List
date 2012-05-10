(function($) {
	$.countdown.regional['fr'] = {
		labels: ['Années', 'Mois', 'Semaines', 'Jours', 'Heures', 'Minutes', 'Secondes'],
		labels1: ['Année', 'Mois', 'Semaine', 'Jour', 'Heure', 'Minute', 'Seconde'],
		compactLabels: ['a', 'm', 's', 'j'],
		whichLabels: function(amount) {
            return (amount > 1 ? 0 : 1);
        },
		timeSeparator: ':', isRTL: false};
	$.countdown.setDefaults($.countdown.regional['fr']);
})(jQuery);
