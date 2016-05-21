<?php

require_once 'vendor/autoload.php';

use Goutte\Client;

// Set up search url
$searchUrl = 'https://www.odontoprev.com.br/redecredenciada/buscaRedeCredenciada?cdMarca=1&produtoAns=320603510&rede=&uf=SP&municipio=355030&especialidade=6&regiao=2&token=724c5345-f15d-4e04-8f65-ba8b12d4950d&pesquisaP=false&bairro=0';

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
