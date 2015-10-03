function checkSproutEmailField(id, fieldHandle, fieldContext) {

	var sproutEmailFieldId = '#' + id;
	var sproutEmailButtonClass = '.' + id;

	// We use setTimeout to make sure our function works every time
	setTimeout(function() 
	{
		// Set up data for the controller.
		var data = {
			'fieldHandle': fieldHandle,
			'fieldContext': fieldContext,
			'value': $(sproutEmailFieldId).val()
		};

		// Query the controller so the regex validation is all done through PHP.
		Craft.postActionRequest('sproutFields/emailValidate', data, function(response) {
			if (response)
			{
				$(sproutEmailButtonClass).addClass('fade');
				$(sproutEmailButtonClass).html('<a href="mailto:' + data.value + '" target="_blank">Send Email &rarr;</a>');
			}
			else
			{
				$(sproutEmailButtonClass).removeClass('fade');
			}
		});

	}, 500);
}