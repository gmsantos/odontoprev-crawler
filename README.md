# odontoprev-crawler

A crawler to get odontoprev dentists data

# Usage

Install composer dependencies

    composer install
    
Navigate to https://www.odontoprev.com.br/redecredenciada/selecaoProduto?cdMarca=1 and select your plan details.

Select the desired region, city, speciality and copy the URL.

Change the URL in your crawler file:

    // Set up search url
    $searchUrl = 'Your URL here';
    
A file named `data.csv` will be created in your project directory.
