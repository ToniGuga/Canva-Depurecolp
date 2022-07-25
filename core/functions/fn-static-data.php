<?php
defined('ABSPATH') || exit;

function canva_get_italian_regions()
{
	$regions = ["sicilia" => "Sicilia", "piemonte" => "Piemonte", "marche" => "Marche", "valle-d-aosta" => "Valle d'Aosta", "toscana" => "Toscana", "campania" => "Campania", "puglia" => "Puglia", "veneto" => "Veneto", "lombardia" => "Lombardia", "emilia-romagna" => "Emilia-Romagna", "trentino-alto-adige" => "Trentino Alto Adige", "sardegna" => "Sardegna", "molise" => "Molise", "calabria" => "Calabria", "abruzzo" => "Abruzzo", "lazio" => "Lazio", "liguria" => "Liguria", "friuli-venezia-giulia" => "Friuli Venezia Giulia", "basilicata" => "Basilicata", "umbria" => "Umbria"];

	return $regions;
}

function canva_get_italian_provinces()
{
	$province = ['AG' => 'Agrigento', 'AL' => 'Alessandria', 'AN' => 'Ancona', 'AO' => 'Aosta', 'AR' => 'Arezzo', 'AP' => 'Ascoli Piceno', 'AT' => 'Asti', 'AV' => 'Avellino', 'BA' => 'Bari', 'BT' => 'Barletta-Andria-Trani', 'BL' => 'Belluno', 'BN' => 'Benevento', 'BG' => 'Bergamo', 'BI' => 'Biella', 'BO' => 'Bologna', 'BZ' => 'Bolzano', 'BS' => 'Brescia', 'BR' => 'Brindisi', 'CA' => 'Cagliari', 'CL' => 'Caltanissetta', 'CB' => 'Campobasso', 'CE' => 'Caserta', 'CT' => 'Catania', 'CZ' => 'Catanzaro', 'CH' => 'Chieti', 'CO' => 'Como', 'CS' => 'Cosenza', 'CR' => 'Cremona', 'KR' => 'Crotone', 'CN' => 'Cuneo', 'EN' => 'Enna', 'FM' => 'Fermo', 'FE' => 'Ferrara', 'FI' => 'Firenze', 'FG' => 'Foggia', 'FC' => 'Forlì-Cesena', 'FR' => 'Frosinone', 'GE' => 'Genova', 'GO' => 'Gorizia', 'GR' => 'Grosseto', 'IM' => 'Imperia', 'IS' => 'Isernia', 'SP' => 'La Spezia', 'AQ' => 'L\'Aquila', 'LT' => 'Latina', 'LE' => 'Lecce', 'LC' => 'Lecco', 'LI' => 'Livorno', 'LO' => 'Lodi', 'LU' => 'Lucca', 'MC' => 'Macerata', 'MN' => 'Mantova', 'MS' => 'Massa-Carrara', 'MT' => 'Matera', 'ME' => 'Messina', 'MI' => 'Milano', 'MO' => 'Modena', 'MB' => 'Monza e della Brianza', 'NA' => 'Napoli', 'NO' => 'Novara', 'NU' => 'Nuoro', 'OR' => 'Oristano', 'PD' => 'Padova', 'PA' => 'Palermo', 'PR' => 'Parma', 'PV' => 'Pavia', 'PG' => 'Perugia', 'PU' => 'Pesaro e Urbino', 'PE' => 'Pescara', 'PC' => 'Piacenza', 'PI' => 'Pisa', 'PT' => 'Pistoia', 'PN' => 'Pordenone', 'PZ' => 'Potenza', 'PO' => 'Prato', 'RG' => 'Ragusa', 'RA' => 'Ravenna', 'RC' => 'Reggio Calabria', 'RE' => 'Reggio Emilia', 'RI' => 'Rieti', 'RN' => 'Rimini', 'RM' => 'Roma', 'RO' => 'Rovigo', 'SA' => 'Salerno', 'SS' => 'Sassari', 'SV' => 'Savona', 'SI' => 'Siena', 'SR' => 'Siracusa', 'SO' => 'Sondrio', 'SU' => 'Sud Sardegna', 'TA' => 'Taranto', 'TE' => 'Teramo', 'TR' => 'Terni', 'TO' => 'Torino', 'TP' => 'Trapani', 'TN' => 'Trento', 'TV' => 'Treviso', 'TS' => 'Trieste', 'UD' => 'Udine', 'VA' => 'Varese', 'VE' => 'Venezia', 'VB' => 'Verbano-Cusio-Ossola', 'VC' => 'Vercelli', 'VR' => 'Verona', 'VV' => 'Vibo Valentia', 'VI' => 'Vicenza', 'VT' => 'Viterbo',];

	return $province;
}

