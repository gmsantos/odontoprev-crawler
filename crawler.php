<?php

require_once 'vendor/autoload.php';

use Goutte\Client;

// Set up search url
$searchUrl = 'Your URL here';;

// Crawler filter
$client = new Client;
$crawler = $client->request('GET', $searchUrl);

$result = $crawler->filter('hr + table')->each(function ($dentists) {
    
    $data = [];
    
    foreach ($dentists as $dentist) {
        $elements = $dentist->getElementsByTagName('td');

        // Filter only specialists
        if (false === strpos($elements[3]->nodeValue, 'Especialidade')) {
            continue;
        }

        $dentistData = [];

        foreach ($elements as $element) {
            $value = trim(preg_replace('/\s{2,}/', '', $element->nodeValue));

            $fieldValue = explode(':', $value);

            if (count($fieldValue) === 2) {
                $dentistData[$fieldValue[0]] = $fieldValue[1];
            }
        }
        
        $data += $dentistData;
    }

    return $data;
});

$file = fopen('data.csv','w');

fputcsv($file, array_keys($result[0]));

foreach ($result as $row) {
    if (! empty($row))
    {
        fputcsv($file, $row);
    }
}

fclose($file);
