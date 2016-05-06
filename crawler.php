<?php

require_once 'vendor/autoload.php';

use Goutte\Client;

function dd($var)
{
    die(var_dump($var));
}

/*
"Doutor(a):Andrezza Matos De Araujo"
string(0) ""
string(0) ""
string(24) "Especialidade:Ortodontia"
string(32) "Endereço:Rua Tabapua, 649 Sl 13"
string(19) " Bairro:Itaim Bibi"
string(17) "Cidade:São Paulo"
string(24) " Telefones:11 3078-9259"
string(5) "UF:SP"
string(15) " CEP:04533-012"
string(35) "Tipo Estabelecimento:Pessoa Física"
string(16) " Nº CRO:115047"
string(38) "Nome Fantasia:ANDREZZA MATOS DE ARAUJO"
*/

// Set up search url
$searchUrl = 'https://www.odontoprev.com.br/redecredenciada/buscaRedeCredenciada?cdMarca=1&produtoAns=320603510&rede=&uf=SP&municipio=355030&especialidade=6&regiao=2&token=724c5345-f15d-4e04-8f65-ba8b12d4950d&pesquisaP=false&bairro=0';

// Crawler filter
$client = new Client;
$crawler = $client->request('GET', $searchUrl);

$data = [];

$data = $crawler->filter('hr + table')->each(function ($dentists) use ($data) {
    foreach ($dentists as $dentist) {
        $elements = $dentist->getElementsByTagName('td');

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

        var_dump($dentistData);

        array_push($data, $dentistData);
    }

    return $data;
});

//var_dump($data);

// Output $data to csv file
