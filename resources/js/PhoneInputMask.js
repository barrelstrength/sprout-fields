(function ($) {

	Craft.PhoneInputMask = Garnish.Base.extend(
	{
		init: function (id, mask, inputMask, inputDefault) {

			sproutPhoneFieldId = '#' + id;
			sproutPhoneButtonClass = '.' + id;

			// We use setTimeout to make sure our function works every time
			setTimeout(function () {
				// Show call text on initial load if not empty
				var phoneNumber = $(sproutPhoneFieldId).val();
				showCallText(phoneNumber, sproutPhoneFieldId)
			}, 500);

			var maskOptions = {
				checked: {
					"mask": mask,
					"clearIncomplete": false,
					"placeholder": "#",
					"autoUnmask": true, // removes characters and accept digits only
					"oncomplete": function (res) {
						var phoneNumber = res.target.value;

						$(sproutPhoneFieldId).addClass('complete');
						showCallText(phoneNumber, this);

					},
					'onKeyDown': function (res) {
						// Remove if delete and backspace key is input
						if (res.keyCode == 8 || res.keyCode == 46) {
							// hide call text if incomplete
							$(sproutPhoneButtonClass).html('');
							$(sproutPhoneFieldId).removeClass('complete');
						}
					},
					"onincomplete": function (res) {
						$(sproutPhoneButtonClass).html('');
						$(sproutPhoneFieldId).removeClass('complete');
					},
					"definitions": {
						'#': {
							validator: "[0-9]",
							cardinality: 1
						}
					}
				},
				unchecked: {
					// Allow the first input to be a plus sign and up to a total of 20 digits
					"mask": "[+]" + inputDefault + "{1,16}",
					"clearIncomplete": false,
					"placeholder": "#",

					"removeMaskOnSubmit": true,
					"definitions": {
						'#': {
							validator: "[0-9]",
							cardinality: 1
						},
						'+': {
							validator: "[+]",
							cardinality: 1,
						}
					}
				}
			}

			if(inputMask == 'checked')
			{
				var maskingOption = maskOptions.checked;
				$(sproutPhoneFieldId).inputmask(maskingOption);
			}
			else
			{
				// @todo - this should be updated to validate phone pattern before displaying the call phone buttom
				$(sproutPhoneFieldId).blur(function() {
					var phoneNumber = $(this).val();
					var currentDom = this;
					var data = {
						'mask' 		 : mask,
						'value' : phoneNumber
					}

					Craft.postActionRequest('sproutFields/phoneValidate', data, function(response) {
						if (response)
						{
							showCallText(phoneNumber, currentDom)
						}
						else
						{
							$(sproutPhoneButtonClass).html('');
						}
					})


				})
			}

			// Show Call Phone Text
			function showCallText(phoneNumber, sproutPhoneFieldElement) {

				if (phoneNumber == '') return;
				$(sproutPhoneFieldElement).next('.sprout-tel-button').addClass('fade');

				$(sproutPhoneFieldElement).next('.sprout-tel-button').html('<a href="tel:' + phoneNumber +
				'" target="_blank">Call Phone &rarr;</a>');

				$(sproutPhoneFieldElement).addClass('complete');
			}
		}
	});

})(jQuery);


