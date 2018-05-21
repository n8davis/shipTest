<?php

namespace ShipFree;

use \Dotenv\Dotenv;
use ShipFree\Shopify\Auth;
use ShipFree\Model\ShopOwner;
class ShipFree
{
    CONST NAME     = 'shipfree';
    CONST PRODUCT_NAME = '' ;
    CONST BASE_URL = 'https://jookbot.com/shipfree/public/';
    CONST DEFAULT_FIRST_ITEM = 4.00;
    CONST DEFAULT_ADDITIONAL_ITEM = 1.00;


    protected $shop;
    protected $config;
    private   $appApiKey;
    private   $appSharedSecret;

    /**
     * App constructor.
     * @param $shop
     */
    function __construct( $shop )
    {
        $dotenv = new Dotenv( dirname( __DIR__ ) );
        $dotenv->load();

        $this->setShop( $shop );
        $this->setAppApiKey( env( 'SHOPIFY_KEY') ) ;
        $this->setAppSharedSecret( env( 'SHOPIFY_SECRET') );
        $this->setConfig([
            'ShopUrl'      => $this->getShop(),
            'ApiKey'       => $this->getAppApiKey(),
            'SharedSecret' => $this->getAppSharedSecret(),
            'AccessToken'  => $this->getShopifyToken(),
        ]);
//        \PHPShopify\ShopifySDK::config( $this->getConfig() );
        Auth::config( $this->getConfig() );
    }

    /**
     * @return array
     */
    public function webhookTopics()
    {
        // EDIT DEPENDING ON STORE CONFIGURATION
        return [
            'app/uninstalled',
        ];
    }

    public static function generateMemberKey($sizeOf)
    {
        if (!isset($sizeOf)) {
            return false;
        } else {
            $chars = "abcdefghjknpqrstwxyzABCDEFGHJKLMQSTUVWXYZ23456789";
            $finalKey = "";
            while (strlen($finalKey) <= $sizeOf) {
                $finalKey .= $chars[mt_rand(0, strlen($chars) - 1)];
            }

            return $finalKey;
        }
    }

    /**
     * @return null
     */
    public function getShopifyToken()
    {
        if( ! is_null(  $this->getShop() ) ) {
            $shop = ShopOwner::where('shop_name', $this->getShop() )->first();
            return is_null( $shop ) ? '' : $shop->shopify_access_token ;
        }
        return null;
    }

    public static function countries()
    {
        return [
            "US" => "United States",
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];
    }

    public static function europeanCountries()
    {
        return [
            [ 'abbr' => "AL", 'name' => "Albania",],
            [ 'abbr' => "AD", 'name' => "Andorra",],
            [ 'abbr' => "AM", 'name' => "Armenia",],
            [ 'abbr' => "AT", 'name' => "Austria",],
            [ 'abbr' => "AZ", 'name' => "Azerbaijan",],
            [ 'abbr' => "BY", 'name' => "Belarus",],
            [ 'abbr' => "BE", 'name' => "Belgium",],
            [ 'abbr' => "BA", 'name' => "Bosnia and Herzegovina",],
            [ 'abbr' => "BG", 'name' => "Bulgaria",],
            [ 'abbr' => "HR", 'name' => "Croatia",],
            [ 'abbr' => "CY", 'name' => "Cyprus",],
            [ 'abbr' => "CZ", 'name' => "Czech Republic",],
            [ 'abbr' => "DK", 'name' => "Denmark",],
            [ 'abbr' => "EE", 'name' => "Estonia",],
            [ 'abbr' => "FI", 'name' => "Finland",],
            [ 'abbr' => "FR", 'name' => "France",],
            [ 'abbr' => "GE", 'name' => "Georgia",],
            [ 'abbr' => "DE", 'name' => "Germany",],
            [ 'abbr' => "GR", 'name' => "Greece",],
            [ 'abbr' => "HU", 'name' => "Hungary",],
            [ 'abbr' => "IS", 'name' => "Iceland",],
            [ 'abbr' => "IE", 'name' => "Ireland",],
            [ 'abbr' => "IT", 'name' => "Italy",],
            [ 'abbr' => "LV", 'name' => "Latvia",],
            [ 'abbr' => "LI", 'name' => "Liechtenstein",],
            [ 'abbr' => "LT", 'name' => "Lithuania",],
            [ 'abbr' => "LU", 'name' => "Luxembourg",],
            [ 'abbr' => "MK", 'name' => "Macedonia, the Former Yugoslav Republic of",],
            [ 'abbr' => "MT", 'name' => "Malta",],
            [ 'abbr' => "MD", 'name' => "Moldova, Republic of",],
            [ 'abbr' => "MC", 'name' => "Monaco",],
            [ 'abbr' => "NL", 'name' => "Netherlands",],
            [ 'abbr' => "NO", 'name' => "Norway",],
            [ 'abbr' => "PL", 'name' => "Poland",],
            [ 'abbr' => "PT", 'name' => "Portugal",],
            [ 'abbr' => "RO", 'name' => "Romania",],
            [ 'abbr' => "RU", 'name' => "Russia",],
            [ 'abbr' => "SM", 'name' => "San Marino",],
            [ 'abbr' => "CS", 'name' => "Serbia and Montenegro",],
            [ 'abbr' => "SK", 'name' => "Slovakia",],
            [ 'abbr' => "SI", 'name' => "Slovenia",],
            [ 'abbr' => "ES", 'name' => "Spain",],
            [ 'abbr' => "CH", 'name' => "Switzerland",],
            [ 'abbr' => "TR", 'name' => "Turkey",],
            [ 'abbr' => "GB", 'name' => "United Kingdom"],
        ];
    }

    public static function isEuropeanCountry( $abbr )
    {
        $destinationCountryName = self::countries()[ $abbr ] ;
        $country = [ 'abbr' => $abbr , 'name' => $destinationCountryName ];
        return in_array( $country , self::europeanCountries() ) ;
    }


    /**
     * @return mixed
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param mixed $shop
     * @return ShipFree
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return ShipFree
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppApiKey()
    {
        return $this->appApiKey;
    }

    /**
     * @param string $appApiKey
     * @return ShipFree
     */
    public function setAppApiKey(string $appApiKey)
    {
        $this->appApiKey = $appApiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppSharedSecret()
    {
        return $this->appSharedSecret;
    }

    /**
     * @param string $appSharedSecret
     * @return ShipFree
     */
    public function setAppSharedSecret(string $appSharedSecret)
    {
        $this->appSharedSecret = $appSharedSecret;
        return $this;
    }



}