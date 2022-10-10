<?php

namespace Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Services\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    public function testAvaliadorDeveEncontrarOMaiorLanceOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, '2000'));
        $leilao->recebeLance(new Lance($joao, '2500'));

        $leiloeiro = new Avaliador();

        //Act - when
        $leiloeiro->avalia($leilao);
        $maiorValor = $leiloeiro->getMaiorValor();

        //Asserts - then
        self::assertEquals(2500, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarOMaiorLanceOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, '2500'));
        $leilao->recebeLance(new Lance($joao, '2000'));

        $leiloeiro = new Avaliador();

        //Act - when
        $leiloeiro->avalia($leilao);
        $maiorValor = $leiloeiro->getMaiorValor();

        //Asserts - then
        self::assertEquals(2500, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarOMenorLanceOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, '2000'));
        $leilao->recebeLance(new Lance($joao, '2500'));

        $leiloeiro = new Avaliador();

        //Act - when
        $leiloeiro->avalia($leilao);
        $menorValor = $leiloeiro->getMenorValor();

        //Asserts - then
        self::assertEquals(2000, $menorValor);
    }

    public function testAvaliadorDeveEncontrarOMenorLanceOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, '2500'));
        $leilao->recebeLance(new Lance($joao, '2000'));

        $leiloeiro = new Avaliador();

        //Act - when
        $leiloeiro->avalia($leilao);
        $menorValor = $leiloeiro->getMenorValor();

        //Asserts - then
        self::assertEquals(2000, $menorValor);
    }
}