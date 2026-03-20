<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$key = '28NA9VSHX5YACPIS';

$stocks = [
    'FRO', // Frontline CHECKCEHCKEHCKE
    'KOZ1.FRK', // Kongsberg Gruppen ASA €
    'MNST', // Monster
    'TSCO.LON', // Tesco PCL £
    'RKH.LON', // Rockhopper Exploration £
    'FSLR', // First Solar Inc $
    'CYSE.LON', // WisdomTree Cybersecurity UCITS ETF USD Acc £
    'NVDA', // NVIDIA Corp $
    'TEM' // Tempus AI Inc - Class A
];

function readJSON($stock){
    $filename = $stock.'.json';
    if (file_exists($filename)){
        $stock_record = json_decode(file_get_contents($filename),true);
    } else {
        $stock_record = json_decode('{}',true);
    }
    return $stock_record;
}
function writeJSON($stock, $data){
    $filename = $stock.'.json';
    file_put_contents($filename, json_encode($data));
}
function callApi($stock){
    global $key;
    //$url = 'https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords=Frontline&apikey='.$key;
    $url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol='.$stock.'&interval=5min&apikey='.$key;
    sleep(1); // limit of the free api
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
    $stock_record = readJSON($stock);
    writeJSON($stock, $stock_record);
    if (!isset($stock_record[$stock][date('Y-m-d', time() - 60 * 60 * 24)])){ // If not set for yesterday's data
        $stock_record = addNewData($stock, $stock_record);
        writeJSON($stock, $stock_record);
    }
}

/*
   foreach ($stocks as $stock){
   checkDataUpToDate($stock);
   }
 */

function getStockAsSeries($stock){
    $stock_record = readJSON($stock);
    $series = [];
    foreach ($stock_record as $day => $value){
        $series[strtotime($day)] = $value['4. close'];
    }
    return array_reverse($series);
}
function renderGraphSVG($series){
    $min_x = min(array_keys($series));
    $width = abs(max(array_keys($series)) - $min_x);
    $x_scale = 100 / $width;
    $min_y = min($series);
    $height = max($series);
    $y_scale = 100 / $height;
    $output = '<svg class="stock-graph" viewBox="0 0 100 100" preserveAspectRatio="none"><polyline fill="#f4f4f4" points="0 100,';
    foreach ($series as $key => $value){
        $output .= (($key - $min_x) * $x_scale).' '.(($height - $value) * $y_scale).','; // remove minimum so there are no negative values
    }
    $output .= '100 100"/></svg>';
    echo $output;
}
function getPercentChange($stock){
    $stock_record = readJSON($stock);
    $original = $stock_record['2026-03-02']['4. close'];
    $current = $stock_record[array_key_first($stock_record)]['4. close'];
    return round((($current - $original) / $original) * 100, 2);
}
function renderStockGraph($stock){
    echo '<div class="stock-container">';
    $series = getStockAsSeries($stock);
    renderGraphSVG($series);
    echo '<span>'.$stock.'</span><span>'.round($series[count($series)-1],2).'</span>';
    echo '<span>Change Since 02.03.26</span><span>'.getPercentChange($stock).'%</span>';
    echo '</div>';
    }
	function renderStockGraphs(){
	    global $stocks;
	    foreach ($stocks as $stock){
		renderStockGraph($stock);
	    }
	}
?>
<html>
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <style>
     body {
	 font-family: Arial;
	 margin-top: 2rem;
	 background: #555555;
	 color: white;
     }
     h1 {
	 text-align: center;
     }
     .main-container {
	 display: flex;
	 flex-wrap: wrap;
	 gap: 0.5rem;
	 width: min(90vw, 1000px);
	 margin: 0 auto;
     }
     .stock-container {
	 display: flex;
	 flex-wrap: wrap;
	 justify-content: space-between;
	 align-items: center;
	 padding: 0.5rem;
	 column-gap: 1rem;
	 row-gap: 0.5rem;
	 background: #333333;
	 flex-basis: 40%;
	 flex-grow: 1;
     }
     .stock-graph, .stock-graph > * {
	 flex-basis: 100%;
	 max-height: 10rem;
     }
     .stock-container > span {
	 flex-basis: 40%;
	 flex-grow: 1;
     }
     .stock-container > span:nth-child(odd) {
	 text-align: right;
     }
    </style>
    
    <body>
	<h1>The Tracker</h1>
	<div class="main-container">
	    <?php renderStockGraphs(); ?>
	</div>
    </body>
</html>
