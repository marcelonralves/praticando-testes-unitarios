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

    public function testAvaliadorDeveBuscar3MaioresValores()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $ana = new Usuario('Ana');
        $joao = new Usuario('João');
        $jorge = new Usuario('Jorge');
        $marcelo = new Usuario('Marcelo');

        $leilao->recebeLance(new Lance($ana, 3000));
        $leilao->recebeLance(new Lance($jorge, 2800));
        $leilao->recebeLance(new Lance($joao, 2400));
        $leilao->recebeLance(new Lance($marcelo, 2000));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maiores = $leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(3000, $maiores[0]->getValor());
        static::assertEquals(2800, $maiores[1]->getValor());
        static::assertEquals(2400, $maiores[2]->getValor());
    }
}