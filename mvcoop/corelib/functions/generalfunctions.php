<?PHP
	# last ver 28.08.2008
	# GeneralFunctions file
	# Created by Sanjay Khadka
	# copyright sanjaykhadka.com.np - checksanjay2000@yahoo.com

	/**
	 * This is a custom function used to split array data to comma separated string. Here the $_data should be the array variable
	 *
	 * @param $_data array
	 * @return string
	 */
	function mergeArray($_data)
	{
		$i=0;
		foreach($_data as $data)
		{
			if($i!=0)
			{
				$merge_value = $merge_value.','.$data;
			}
			else
			{
				$merge_value = $data;
			}
			$i++;
		}
		return($merge_value);
	}
	
	/**
	 * This is a custom function used for the testing of array value.
	 *
	 * @param $_var array
	 * @param $_die int
	 * @param $_par int
	 * @return pre formatted string
	 */
	function debug( $_var, $_die = 0, $_par= 0 ) {
		echo "<pre><code><div style=\"color:orange\">";
		if( !$_par ){ var_dump( $_var );} else{ print_r( $_var ); }
		echo "</div></code></pre>";
		
		if ( $_die ) die();
	}
	
	/**
	 * This is a custom function used for the testing of single value.
	 *
	 * @param $_var string
	 * @param $_die int
	 * @return pre formatted string
	 */
	function __e($_var, $_die = 0)
	{
		echo "<br><pre><code><div style=\"color:orange\">";
		echo "&nbsp;&nbsp;&nbsp;";
		echo $_var;
		echo "</div></code></pre>";
		
		if( $_die ) die();
	}
	
	/**
	 * GET DIR CONTENTS lists the contents of a directory
	 *
	 * @param $_dir string(directory_path)
	 * @param unknown_type $_index
	 * @param unknown_type $_dirs
	 * @return unknown
	 */
	function getDirContent( $_dir, $_index = 0, $_dirs = 0 )
	{
		$dir = dir( $_dir );
		$i = 0;
		while ( false !== ( $entry = $dir->read() ) )
		{
			if ( $entry != '.' && $entry != '.htaccess' && $entry != '..' )
			{
				if ( $_dirs && is_dir( $_dir . '/' . $entry ) )
				{
					$res[] = $entry;
				} else {
					if ( $entry == 'index.php' )
					{
						if ( $_index )
						$res[] = $entry;
					} else {
						$res[] = $entry;
					}
				}
			}
		}
		$dir->close();
		return $res;
	}
	
//	public static 
	function backtrace($_var, $_die = 0, $_par= 0 ) {
		if($_var == 'print') {
			debug_print_backtrace();
		}
		else {
			debug(debug_backtrace(), $_die, $_par);
		}
	}
	
	//public static 
	function basePath()
	{
		return getcwd(); //Gets the current working directory
	}
	
	### static country list generating function
	/**
	 * This custom function generates the list of countries.
	 *
	 * @return array
	 */
	function getCountryList()
	{  
		$country = array( "Afghanistan" , "Albania" , "Algeria" , "American Samoa" , "Andorra" , "Angola" , "Anguilla" , "Antarctica" , "Antigua and Barbuda" , "Argentina" , "Armenia" , "Arctic Ocean" , "Aruba" , "Ashmore and Cartier Islands" , "Atlantic Ocean" , "Australia" , "Austria" , "Azerbaijan" , "Bahamas" , "Bahrain" , "Baker Island" , "Bangladesh" , "Barbados" ,  "Bassas da India" , "Belarus" , "Belgium" , "Belize" , "Benin" , "Bermuda" , "Bhutan" , "Bolivia" , "Bosnia and Herzegovina" , "Botswana" , "Bouvet Island" , "Brazil" , "British Virgin Islands" , "Brunei" , "Bulgaria" , "Burkina Faso" , "Burundi" , "Cambodia" , "Cameroon" , "Canada" , "Cape Verde" , "Cayman Islands" , "Central African Republic" , "Chad" , "Chile" , "China" , "Christmas Island" , "Clipperton Island" , "Cocos Islands" , "Colombia" , "Comoros" , "Cook Islands" , "Coral Sea Islands" , "Costa Rica" , "Cote d'Ivoire" , "Croatia" , "Cuba" , "Cyprus" , "Czech Republic" , "Denmark" , "Democratic Republic of the Congo" , "Djibouti" , "Dominica" , "Dominican Republic" , "East Timor" , "Ecuador" , "Egypt" , "El Salvador" , "Equatorial Guinea" , "Eritrea" , "Estonia" , "Ethiopia" , "Europa Island" , "Falkland Islands (Islas Malvinas)" , "Faroe Islands" , "Fiji" , "Finland" , "France" , "French Guiana" , "French Polynesia" , "French Southern and Antarctic Lands" , "Gabon" , "Gambia" , "Gaza Strip" , "Georgia" , "Germany" , "Ghana" , "Gibraltar" , "Glorioso Islands" , "Greece" , "Greenland" , "Grenada" , "Guadeloupe" , "Guam" , "Guatemala" , "Guernsey" , "Guinea" , "Guinea-Bissau" , "Guyana" , "Haiti" , "Heard Island and McDonald Islands" , "Honduras" , "Hong Kong" , "Howland Island" , "Hungary" , "Iceland" , "India" , "Indian Ocean" , "Indonesia" , "Iran" , "Iraq" , "Ireland" , "Isle of Man" , "Israel" , "Italy" , "Jamaica" , "Jan Mayen" , "Japan" , "Jarvis Island" , "Jersey" , "Johnston Atoll" , "Jordan" , "Juan de Nova Island" , "Kazakhstan" , "Kenya" , "Kingman Reef" , "Kiribati" , "Kerguelen Archipelago" , "Kuwait" , "Kyrgyzstan" , "Laos" , "Latvia" , "Lebanon" , "Lesotho" , "Liberia" , "Libya" , "Liechtenstein" , "Lithuania" , "Luxembourg" , "Macau" , "Macedonia" , "Madagascar" , "Malawi" , "Malaysia" , "Maldives" , "Mali" , "Malta" , "Marshall Islands" , "Martinique" , "Mauritania" , "Mauritius" , "Mayotte" , "Mexico" , "Micronesia" , "Midway Islands" , "Moldova" , "Monaco" , "Mongolia" , "Montenegro" , "Montserrat" , "Morocco" , "Mozambique" , "Myanmar" , "Namibia" , "Nauru" , "Navassa Island" , "Nepal" , "Netherlands" , "Netherlands Antilles" , "New Caledonia" , "New Zealand" , "Nicaragua" , "Niger" , "Nigeria" , "Niue" , "Norfolk Island" , "North Korea" , "Northern Mariana Islands" , "Norway" , "Oman" , "Pacific Ocean" , "Pakistan" , "Palau" , "Palmyra Atoll" , "Panama" , "Papua New Guinea" , "Paracel Islands" , "Paraguay" , "Peru" , "Philippines" , "Pitcairn Islands" , "Poland" , "Portugal" , "Puerto Rico" , "Qatar" , "Reunion" , "Republic of the Congo" , "Romania" , "Russia" , "Rwanda" , "Saint Helena" , "Saint Kitts and Nevis" , "Saint Lucia" , "Saint Pierre and Miquelon" , "Saint Vincent and the Grenadines" , "Samoa" , "San Marino" , "Sao Tome and Principe" , "Saudi Arabia" , "Senegal" , "Serbia" , "Seychelles" , "Sierra Leone" , "Singapore" , "Slovakia" , "Slovenia" , "Solomon Islands" , "Somalia" , "South Africa" , "South Georgia" , "South Korea" , "Spain" , "Spratly Islands" , "Sri Lanka" , "Sudan" , "Suriname" , "Svalbard" , "Swaziland" , "Sweden" , "Switzerland" , "Syria" , "Taiwan" , "Tajikistan" , "Tanzania" , "Thailand" , "Togo" , "Tokelau" , "Tonga" , "Trinidad and Tobago" , "Tromelin Island" , "Tunisia" , "Turkey" , "Turkmenistan" , "Turks and Caicos Islands" , "Tuvalu" , "Uganda" , "Ukraine" , "United Arab Emirates" , "United Kingdom" , "USA" , "Uruguay" , "Uzbekistan" , "Vanuatu" , "Venezuela" , " Viet Nam" , "Virgin Islands" , "Wake Island" , " Wallis and Futuna" , " WestBank" , "Western Sahara" , "Yemen" , "Yugoslavia" , "Zambia" , "Zimbabwe");
		return $country;
	}

?>