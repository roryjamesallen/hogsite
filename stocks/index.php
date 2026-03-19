<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$key = '28NA9VSHX5YACPIS';

$stocks = [
    'CYSE.LON', // WisdomTree Cybersecurity UCITS ETF USD Acc £
    'RKH.LON', // Rockhopper Exploration £
    'NVDA', // NVIDIA Corp $
    'FSLR', // First Solar Inc $
    'KOZ1.FRK', // Kongsberg Gruppen ASA €
    'TSCO.LON', // Tesco PCL £
    'TEM', // Tempus AI Inc - Class A
    'HOLN', // Holcim CHF CHECKCEHCKEHCKE
    'MNST', // Monster $ CHECKCEHCKEHCKE
    'FRO' // Frontline CHECKCEHCKEHCKE
];

function callApi($stock){
    global $key;
    //$url = 'https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords=Frontline&apikey='.$key;
    $url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol='.$stock.'&interval=5min&apikey='.$key;
    return json_decode(file_get_contents($url),true);
}
function addNewData($stock, $stock_record){
    $new_data = callApi($stock);
    foreach($new_data['Time Series (Daily)'] as $date_record => $record){
	if (!isset($stock_record[$date_record])){
	    $stock_record[$date_record] = $record;
	}
    }
    return $stock_record;
}
function checkDataUpToDate($stock){
    $filename = $stock.'.json';
    if (file_exists($filename)){
	$stock_record = json_decode(file_get_contents($filename),true);
    } else {
	$stock_record = json_decode('{}',true);
    }
    if (!isset($stock_record[$stock][date('Y-m-d', time() - 60 * 60 * 24)])){ // If not set for yesterday's data
	$stock_record = addNewData($stock, $stock_record);
	file_put_contents($filename, json_encode($stock_record));
    }
}

for ($stocks as $stock){
    checkDataUpToDate($stock);
}

?>
