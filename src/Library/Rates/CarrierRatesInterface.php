<?php

namespace ControleOnline\Library\Rates;

interface CarrierRatesInterface
{
  public function setUser (Model\User $user);

  public function getRates(Model\Quotation $quotation): array;
}
