<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Services\Avaliador;

$leilao = new Leilao('Fiat 147 0KM');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($maria, '2500'));
$leilao->recebeLance(new Lance($joao, '2500'));

$leiloeiro = new Avaliador();

//Act - when
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

//Asserts - then
$valorEsperado = 2500;

if($valorEsperado == $maiorValor) {
    echo "Teste Ok";
} else {
    echo "Teste Falhou";
}