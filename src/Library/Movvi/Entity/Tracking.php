<?php

namespace ControleOnline\Library\Movvi\Entity;

class Tracking
{
  /**
   * @var string
   */
  private $dataHora;

  /**
   * @var string
   */
  private $dominio;

  /**
   * @var string
   */
  private $filial;

  /**
   * @var string
   */
  private $cidade;

  /**
   * @var string
   */
  private $ocorrencia;

  /**
   * @var string
   */
  private $descricao;

  /**
   * @var string
   */
  private $tipo;

  /**
   * @var string
   */
  private $dataHoraEfetiva;

  /**
   * @var string
   */
  private $nomeRecebedor;

/**
   * @var string
   */
  private $trackingNumber;

  /**
   * @var string
   */
  private $nroDocRecebedor;

  public function getDataHora(): string
  {
    return $this->dataHora;
  }

  public function setDataHora(string $dataHora): self
  {
    $this->dataHora = $dataHora;

    return $this;
  }

  public function getDominio(): string
  {
    return $this->dominio;
  }

  public function setDominio(string $dominio): self
  {
    $this->dominio = $dominio;

    return $this;
  }

  public function getFilial(): string
  {
    return $this->filial;
  }

  public function setFilial(string $filial): self
  {
    $this->filial = $filial;

    return $this;
  }

  public function getCidade(): string
  {
    return $this->cidade;
  }

  public function setCidade(string $cidade): self
  {
    $this->cidade = $cidade;

    return $this;
  }

  public function getOcorrencia(): string
  {
    return $this->ocorrencia;
  }

  public function setOcorrencia(string $ocorrencia): self
  {
    $this->ocorrencia = $ocorrencia;

    return $this;
  }

  public function getDescricao(): string
  {
    return $this->descricao;
  }

  public function setDescricao(string $descricao): self
  {
    $this->descricao = $descricao;

    return $this;
  }

  public function getTipo(): ?string
  {
    return $this->tipo;
  }

  public function setTipo(?string $tipo): self
  {
    $this->tipo = $tipo;

    return $this;
  }

  public function getDataHoraEfetiva(): string
  {
    return $this->dataHoraEfetiva;
  }

  public function setDataHoraEfetiva(string $dataHoraEfetiva): self
  {
    $this->dataHoraEfetiva = $dataHoraEfetiva;

    return $this;
  }

  public function getNomeRecebedor(): ?string
  {
    return $this->nomeRecebedor;
  }

  public function setNomeRecebedor(?string $nomeRecebedor): self
  {
    $this->nomeRecebedor = $nomeRecebedor;

    return $this;
  }

  public function getNroDocRecebedor(): ?string
  {
    return $this->nroDocRecebedor;
  }

  public function setNroDocRecebedor(?string $nroDocRecebedor): self
  {
    $this->nroDocRecebedor = $nroDocRecebedor;

    return $this;
  }

  public function getTrackingNumber(): ?int
  {
    return $this->trackingNumber;
  }

  public function setTrackingNumber(string $trackingNumber): self
  {
    $this->trackingNumber = $trackingNumber;

    return $this;
  }

  public function getSystemType(){
    return 'meridional cargas';
  }
}
