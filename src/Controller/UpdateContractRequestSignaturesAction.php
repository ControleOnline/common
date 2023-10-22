<?php

namespace ControleOnline\Controller;

use ControleOnline\Entity\MyContract;
use ControleOnline\Library\Provider\Signature\Contract;
use Symfony\Component\HttpFoundation\JsonResponse;


class UpdateContractRequestSignaturesAction extends Contract
{

  public function __invoke(MyContract $data)
  {
    if ($data->getContractStatus() == 'Waiting signatures') {
      throw new \Exception('The contract status can not be updated');
    }
    try {
      $data = $this->sign($data);
    } catch (\Exception $e) {
      $response = [
        'response' => [
          'error'   => $e->getMessage(),
          'success' => false,
        ],
      ];

      return new JsonResponse($response, 422);
    }
    return $data;
  }
}
