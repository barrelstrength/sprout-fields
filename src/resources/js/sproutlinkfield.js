function checkSproutLinkField(id, fieldHandle, fieldContext) {

	var sproutLinkFieldId = '#' + id;
	var sproutLinkButtonClass = '.' + id;

	// We use setTimeout to make sure our function works every time
	setTimeout(function()
	{
		// Set up data for the controller.
		var data = {
			'fieldHandle': fieldHandle,
			'fieldContext': fieldContext,
			'value': $(sproutLinkFieldId).val()
		};

		// Query the controller so the regex validation is all done through PHP.
		Craft.postActionRequest('sprout-fields/sprout-fields/link-validate', data, function(response) {
			if (response)
			{
				$(sproutLinkButtonClass).addClass('fade');
				$(sproutLinkButtonClass).html('<a href="' + data.value + '" target="_blank" class="sproutfields-icon">&#xf0a9;</a>');
			}
			else
			{
				$(sproutLinkButtonClass).removeClass('fade');
			}
		});

	}, 500);
}