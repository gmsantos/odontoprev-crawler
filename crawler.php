<?php

require_once 'vendor/autoload.php';

use Goutte\Client;

// Set up search url
$searchUrl = 'https://www.odontoprev.com.br/redecredenciada/buscaRedeCredenciada?cdMarca=1&produtoAns=320603510&rede=&uf=SP&municipio=355030&especialidade=6&regiao=2&token=724c5345-f15d-4e04-8f65-ba8b12d4950d&pesquisaP=false&bairro=0';

// Crawler filter
$client = new Client;
$crawler = $client->request('GET', $searchUrl);

$data = [];

$crawler->filter('hr + table')->each(function ($node) use ($data) {
    print $node->text()."\n";
});

// Output $data to csv file