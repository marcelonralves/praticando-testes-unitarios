<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance): void
    {
        if(!empty($this->lances) && $this->checarUltimoUsuario($lance)) {
            throw new \DomainException('Não é possível receber mais de um lance por usuário');
        }

        $totalLanceUsuario = $this->quantidadeLancePorUsuario($lance->getUsuario());

        if($totalLanceUsuario >= 5) {
            throw new \DomainException('Não é possível receber mais de cinco lances por usuário');
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    public function checarUltimoUsuario(Lance $lance): bool
    {
        $ultimoLance = $this->lances[count($this->lances) - 1];
        return $lance->getUsuario() === $ultimoLance->getUsuario();
    }

    /**
     * @param Usuario $usuario
     * @return int
     */
    public function quantidadeLancePorUsuario(Usuario $usuario): int
    {
        return array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() === $usuario) {
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            }, 0
        );
    }
}
