<?php

namespace Craft;

require dirname(__FILE__) .'/../vendor/autoload.php';

use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use CommerceGuys\Addressing\Repository\CountryRepository;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Model\Address;

class SproutFields_AddressFormFieldService extends BaseApplicationComponent
{
	protected $addressObj;
	protected $subdivisonObj;

	private $name;
	private $addressField;
	private $namespaceInputName;
	protected $countryCode;
	private $sproutAddress;

	public function setParams($countryCode, $name, $sproutAddress, $addressField, $namespaceInputName)
	{

		$this->name = $name;
		$this->namespaceInputName = $namespaceInputName;
		$this->addressField = $addressField;
		$this->countryCode = $countryCode;
		$this->sproutAddress = $sproutAddress;
	}

	public function setForm($ajax = false)
	{

		$countryCode = $this->countryCode;
		// add fields prefix when calling external ajax
		if($ajax)
		{
			$this->name = $this->namespaceInputName;
		}
		$output = '';
		$addressRepo = new AddressFormatRepository;
		$this->subdivisonObj = new SubdivisionRepository;
		$this->addressObj = $addressRepo->get($countryCode);
		$format = $this->addressObj->getFormat();

		// Remove unused format
		$format = preg_replace('/%recipient/', '', $format);
		$format = preg_replace('/%organization/', '', $format);

		// Insert line break based on the format
		$format = nl2br($format);

		// More whitespace
		$format = preg_replace('/,/', '<span class="comma">,</span>', $format);

		$format = preg_replace('/%addressLine1/', $this->addressLine('address1'), $format);
		$format = preg_replace('/%addressLine2/', $this->addressLine('address2'), $format);
		$format = preg_replace('/%dependentLocality/', $this->dependentLocality(), $format);
		$format = preg_replace('/%locality/', $this->locality(), $format);
		if(preg_match('/%sortingCode/', $format))
		{
			$format = preg_replace('/%sortingCode/', $this->sortingCode(), $format);
		}
		$format = preg_replace('/%administrativeArea/', $this->administrativeArea(), $format);
		$format = preg_replace('/%postalCode/', $this->postalCode(), $format);
		$output.= $format;


		return $output;
	}

	public function countryInput()
	{
		$countries = $this->getCountries();
		$output = '';
		$output.= $this->renderHeading('Country');
		$countryCode = $this->countryCode;
		$output.= " <select class='sproutAddressCountry' data-address='" . $this->sproutAddress . "' data-namespace='" . $this->namespaceInputName . "' name='" . $this->name . "[countryCode]'>";
		foreach($countries as $ck => $cv)
		{
			$selected = ($ck == $countryCode) ? "selected='selected'" : '';
			$output.= "<option $selected value='" . $ck . "'>" . $cv . "</option>";
		}
		$output.= "</select>";
		return $this->renderOutput($output);
	}

	private function addressLine($addressName)
	{

		$output = '';
		if($addressName == 'address1')
		{
			$output.= $this->renderHeading('Address');
		}
		$value = $this->addressField->$addressName;
		$output.= "<div class='input'>
				<input class='text' type='text' name='" . $this->name . "[$addressName]' value='$value' />
				</div>";


		return $this->renderOutput($output);
	}

	private function sortingCode()
	{
		$output = '';
		$output .= $this->renderHeading(Craft::t('Sorting Code'));
		$value = $this->addressField->sortingCode;
		$output .= "<div class='input'>
				<input class='text' type='text' name='" . $this->name . "[sortingCode]' value='$value' />
				</div>";

		return $output;
	}

	private function locality()
	{
		$output = '';
		$output .= $this->renderHeading($this->addressObj->getLocalityType());
		$value = $this->addressField->locality;
		$output .= "<div class='input'>
				<input class='text' type='text' name='" . $this->name . "[locality]' value='$value' />
				</div>";
		return $this->renderOutput($output);
	}

	private function dependentLocality()
	{
		$output = '';
		$output .= $this->renderHeading($this->addressObj->getDependentLocalityType());
		$value = $this->addressField->dependentLocality;
		$output .= "<div class='input'>
				<input class='text' type='text' name='" . $this->name . "[dependentLocality]' value='$value' />
				</div>";
		return $this->renderOutput($output);
	}

	private function administrativeArea()
	{
		$output = '';
		$output .= $this->renderHeading($this->addressObj->getAdministrativeAreaType());
		$value = $this->addressField->administrativeArea;


		$output.= "<div class='input'>";
		if($this->subdivisonObj->getAll($this->countryCode))
		{
			$states = $this->subdivisonObj->getAll($this->countryCode);
			if(!empty($states))
			{
				$output.= "<select class='sproutAddressAdministrativeArea' name='" . $this->name . "[administrativeArea]'>";

				foreach($states as $state)
				{

					$stateName = $state->getName();
					$selected = ($value == $stateName) ? "selected='selected'" : '';
					$output .= '<option ' . $selected . ' value="' . $stateName . '">' . $stateName . '</option>';
				}
				$output .= "</select>";
			}
		}
		else
		{
			$output .= "<input class='text' type='text' name='" . $this->name . "[administrativeArea]' value='$value' />";
		}
		$output.= "</div>";


		return $this->renderOutput($output);
	}

	public function postalCode()
	{
		$output = '';
		$output .= $this->renderHeading($this->addressObj->getPostalCodeType());
		$value = $this->addressField->postalCode;
		$output .= "<div class='input'>
					<input class='text' type='text' name='" . $this->name . "[postalCode]' value='$value' />
				</div>";
		return $this->renderOutput($output);
	}

	public function renderHeading($title)
	{
		$output = '';
		$output.= '<label>' . Craft::t(str_replace('_', ' ', ucwords($title))) . '</label>';
		return $output;
	}

	public function renderOutput($field)
	{
		$output = '';
		$output = "<div class='field'>";
		$output.= $field;
		$output .= "</div>";
		return $output;
	}

	public function displayAddress($model)
	{
		$addressFormatRepository  =  new AddressFormatRepository();
		$countryRepository  =  new CountryRepository();
		$subdivisionRepository  =  new SubdivisionRepository();

		$formatter = new DefaultFormatter($addressFormatRepository, $countryRepository, $subdivisionRepository);
		$address   =  new Address();
		$address   =  $address
			->setCountryCode( $model->countryCode )
			->setAdministrativeArea( $model->administrativeArea )
			->setLocality( $model->locality )
			->setAddressLine1( $model->address1 )
			->setAddressLine2( $model->address2 );

		if($model->dependentLocality != null)
		{
			$address->setDependentLocality($model->dependentLocality);
		}

		return  $formatter->format($address);
	}

	public function validate($value)
	{
		if(!isset($value['countryCode'])) return true;

		$countryCode = $value['countryCode'];

		if(empty($value['postalCode']))
		{
			return true;
		}
		$addressFormatRepository  =  new AddressFormatRepository();

		$addressObj = $addressFormatRepository->get($countryCode);

		$postalName = $addressObj->getPostalCodeType();
		$errors = array();
		if($addressObj->getPostalCodePattern() != null)
		{
			$pattern = $addressObj->getPostalCodePattern();

			if (preg_match("/^" . $pattern . "$/", $value['postalCode']))
			{
				return true;
			} else {
				$errors[] = Craft::t(ucwords($postalName)  . ' is invalid.');
			}
		}

		if(!empty($errors)) return $errors;

		return true;
	}

	private function getCountries()
	{
		$countries = array
		(
			'AF' => 'Afghanistan',
			'AX' => 'Aland Islands',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua And Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BA' => 'Bosnia And Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'BN' => 'Brunei Darussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CG' => 'Congo',
			'CD' => 'Congo, Democratic Republic',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CI' => 'Cote D\'Ivoire',
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'GQ' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands (Malvinas)',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard Island & Mcdonald Islands',
			'VA' => 'Holy See (Vatican City State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran, Islamic Republic Of',
			'IQ' => 'Iraq',
			'IE' => 'Ireland',
			'IM' => 'Isle Of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KR' => 'Korea',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => 'Lao People\'s Democratic Republic',
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libyan Arab Jamahiriya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao',
			'MK' => 'Macedonia',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States Of',
			'MD' => 'Moldova',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestinian Territory, Occupied',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'BL' => 'Saint Barthelemy',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts And Nevis',
			'LC' => 'Saint Lucia',
			'MF' => 'Saint Martin',
			'PM' => 'Saint Pierre And Miquelon',
			'VC' => 'Saint Vincent And Grenadines',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'ST' => 'Sao Tome And Principe',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia And Sandwich Isl.',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard And Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syrian Arab Republic',
			'TW' => 'Taiwan',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad And Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks And Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom',
			'US' => 'United States',
			'UM' => 'United States Outlying Islands',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Viet Nam',
			'VG' => 'Virgin Islands, British',
			'VI' => 'Virgin Islands, U.S.',
			'WF' => 'Wallis And Futuna',
			'EH' => 'Western Sahara',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe',
		);

		return $countries;
	}

}