$(function() {

	// NAVBAR

	$('#barButton').on('click', function() {
		$('#basicMenu').css('display', 'none');
		$('#burgerMenu').css('display', 'block');

	});

	$('#closeButton').on('click', function() {
		$('#burgerMenu').css('display', 'none');
		$('#basicMenu').css('display', 'inline');
	});

	// FORMULAIRE NOUVELLE OBSERVATION

	// Suppression de la class form-group
	$('#nao_birdbundle_observation_date').removeAttr('class');
	// Ajout class row
	$('#nao_birdbundle_observation_date').attr('class', 'row');
	// On change les attributs du select month, day et year
	$('#nao_birdbundle_observation_date_day, #nao_birdbundle_observation_date_month, #nao_birdbundle_observation_date_year').attr('class', 'form-control');
	// On entoure les selects month, day et year
	$('#nao_birdbundle_observation_date_month, #nao_birdbundle_observation_date_day, #nao_birdbundle_observation_date_year').wrap('<div class="col-sm-4"><div class="form-group"></div></div>');

});
