$(function() {

	var inputBirdSearchBar = $('#birdSearchBar');

	inputBirdSearchBar.on('keyup', function() {

		if (inputBirdSearchBar.val() != '') // Si l'utilisateur envoie une valeur
		{
			$('#partResult').load('resultsSearchBirds #results', {value: inputBirdSearchBar.val()});
		}
		else // S'il n'y a pas de résultat on efface le bloc
		{
			$('#results').css('display', 'none');	
		}
	});
});
