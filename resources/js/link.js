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
		Craft.postActionRequest('sproutFields/linkValidate', data, function(response) {
			if (response)
			{
				$(sproutLinkButtonClass).addClass('fade');
				$(sproutLinkButtonClass).html('<a href="' + data.value + '" target="_blank">Visit URL &rarr;</a>');
			}
			else
			{
				$(sproutLinkButtonClass).removeClass('fade');
			}
		});

	}, 500);
}