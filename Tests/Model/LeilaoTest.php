<?php

namespace Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível receber mais de um lance por usuário');

        $leilao = new Leilao('Notebook novo');

        $bia = new Usuario('Bia');
        $leilao->recebeLance(new Lance($bia, 2000));
        $leilao->recebeLance(new Lance($bia, 2500));
    }

    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível receber mais de cinco lances por usuário');

        $leilao = new Leilao('Brasília Amarela');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));

        $leilao->recebeLance(new Lance($joao, 6000));
    }

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores)
    {
        static::assertCount($qtdLances, $valores);

        foreach($valores as $i => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
        }
    }

    public function geraLances(): array
    {
        $leilaoDoisLances = new Leilao('Fiat 147 0KM');

        $joao = new Usuario('João');
        $ana = new Usuario('Ana');
        $jose = new Usuario('José');

        $leilaoDoisLances->recebeLance(new Lance($joao, 4000));
        $leilaoDoisLances->recebeLance(new Lance($ana, 2000));
        $leilaoDoisLances->recebeLance(new Lance($jose, 1500));

        $leilaoUmLance = new Leilao('Marea Completo');
        $leilaoUmLance->recebeLance(new Lance($jose, 2000));

        return [
            [2, $leilaoDoisLances, [4000,2000]],
            [1, $leilaoUmLance, [2000]]
        ];
    }
}