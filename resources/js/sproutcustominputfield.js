function checkSproutCustomInputField(id, fieldHandle, fieldContext) {

	var sproutCustomInputFieldId = '#' + id;
	var sproutCustomInputClass = '.' + id;

	// We use setTimeout to make sure our function works every time
	setTimeout(function()
	{
		// Set up data for the controller.
		var data = {
			'fieldHandle': fieldHandle,
			'fieldContext': fieldContext,
			'value': $(sproutCustomInputFieldId).val()
		};

		// Query the controller so the regex validation is all done through PHP.
		Craft.postActionRequest('sproutFields/customInputValidate', data, function(response) {
			if (response)
			{
				$(sproutCustomInputClass).addClass('fade');
			}
			else
			{
				$(sproutCustomInputClass).removeClass('fade');
			}
		});

	}, 500);
}