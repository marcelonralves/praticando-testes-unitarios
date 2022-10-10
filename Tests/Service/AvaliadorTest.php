<?php

namespace Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Services\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private Avaliador $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    public function testLeilaoNaoPodeSerAvaliadoVazio()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar um leilão vazio.');

        $leilao = new Leilao('Gol G4 completo');
        $this->leiloeiro->avalia($leilao);
    }

    /**
     * @dataProvider entregaLeiloes
     *
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        //Act - when
         $this->leiloeiro->avalia($leilao);
        $menorValor =  $this->leiloeiro->getMenorValor();

        //Asserts - then
        self::assertEquals(2000, $menorValor);
    }

    /**
     * @dataProvider entregaLeiloes
     *
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        //Act - when
        $this->leiloeiro->avalia($leilao);
        $maiorValor =  $this->leiloeiro->getMaiorValor();

        //Asserts - then
        self::assertEquals(2700, $maiorValor);
    }
    /**
     * @dataProvider entregaLeiloes
     *
     */
    public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        //Act - when
        $this->leiloeiro->avalia($leilao);
        $menorValor =  $this->leiloeiro->getMaioresLances();

        //Asserts - then
        self::assertEquals(2700, $menorValor[0]->getValor());
        self::assertEquals(2500, $menorValor[1]->getValor());
        self::assertEquals(2000, $menorValor[2]->getValor());
    }

    public function leilaoOrdemCrescente(): Leilao
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, '2000'));
        $leilao->recebeLance(new Lance($joao, '2500'));
        $leilao->recebeLance((new Lance($ana, '2700')));

        return $leilao;
    }

    public function leilaoOrdemDecrescente(): Leilao
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, '2500'));
        $leilao->recebeLance(new Lance($joao, '2000'));
        $leilao->recebeLance((new Lance($ana, '2700')));

        return $leilao;
    }

    public function leilaoOrdemAleatoria(): Leilao
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, '2500'));
        $leilao->recebeLance((new Lance($ana, '2700')));
        $leilao->recebeLance(new Lance($joao, '2000'));

        return $leilao;
    }

    public function entregaLeiloes(): array
    {
        return [
            [$this->leilaoOrdemCrescente()],
            [$this->leilaoOrdemDecrescente()],
            [$this->leilaoOrdemAleatoria()]
        ];
    }
}