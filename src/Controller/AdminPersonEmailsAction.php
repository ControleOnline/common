<?php

namespace ControleOnline\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

use ControleOnline\Entity\People;
use ControleOnline\Entity\Email;
use ControleOnline\Entity\Person;

class AdminPersonEmailsAction
{
    /**
     * Entity Manager
     *
     * @var EntityManagerInterface
     */
    private $manager = null;

    /**
     * Request
     *
     * @var Request
     */
    private $request  = null;

    /**
     * Security
     *
     * @var Security
     */
    private $security = null;

    /**
     * Current user
     *
     * @var \ControleOnline\Entity\User
     */
    private $currentUser = null;

    public function __construct(EntityManagerInterface $manager, Security $security)
    {
        $this->manager     = $manager;
        $this->security    = $security;
        $this->currentUser = $security->getUser();
    }

    public function __invoke(Person $data, Request $request): JsonResponse
    {
        $this->request = $request;

        try {

            $methods = [
                Request::METHOD_PUT    => 'createEmail',
                Request::METHOD_DELETE => 'deleteEmail',
                Request::METHOD_GET    => 'getEmails'  ,
            ];

            $payload   = json_decode($this->request->getContent(), true);
            $operation = $methods[$request->getMethod()];
            $result    = $this->$operation($data, $payload);

            return new JsonResponse([
                'response' => [
                    'data'    => $result,
                    'count'   => 1,
                    'error'   => '',
                    'success' => true,
                ],
            ], 200);

        } catch (\Exception $e) {

            return new JsonResponse([
                'response' => [
                    'data'    => [],
                    'count'   => 0,
                    'error'   => $e->getMessage(),
                    'success' => false,
                ],
            ]);

        }
    }

    private function createEmail(Person $person, array $payload): ?array
    {
        try {
            $this->manager->getConnection()->beginTransaction();

            if (!isset($payload['email']) || !filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('Email value is not valid');
            }

            $company = $this->manager->getRepository(People::class)->find($person->getId());
            $email   = $this->manager->getRepository(Email::class)->findOneBy(['email' => $payload['email']]);

            if ($email instanceof Email) {
                if ($email->getPeople() instanceof People) {
                    throw new \InvalidArgumentException('O email já está em uso');
                }

                $email->setPeople($company);
            }
            else {
                $email = new Email();
                $email->setEmail    ($payload['email']);
                $email->setConfirmed(false);
                $email->setPeople   ($company);
            }

            $this->manager->persist($email);

            $this->manager->flush();
            $this->manager->getConnection()->commit();

            return [
                'id' => $email->getId()
            ];

        } catch (\Exception $e) {
            if ($this->manager->getConnection()->isTransactionActive())
                $this->manager->getConnection()->rollBack();

            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    private function deleteEmail(Person $person, array $payload): bool
    {
        try {
            $this->manager->getConnection()->beginTransaction();

            if (!isset($payload['id'])) {
                throw new \InvalidArgumentException('Document id is not defined');
            }

            $company = $this->manager->getRepository(People::class)->find($person->getId());
            

            $email = $this->manager->getRepository(Email::class)->findOneBy(['id' => $payload['id'], 'people' => $company]);
            if (!$email instanceof Email) {
                throw new \InvalidArgumentException('Person email was not found');
            }

            $this->manager->remove($email);

            $this->manager->flush();
            $this->manager->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            if ($this->manager->getConnection()->isTransactionActive())
                $this->manager->getConnection()->rollBack();

            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    private function getEmails(Person $person, ?array $payload = null): array
    {
        $members = [];
        $company = $this->manager->getRepository(People::class )->find($person->getId());
        $emails  = $this->manager->getRepository(Email::class)->findBy(['people' => $company]);

        foreach ($emails as $email) {
            $members[] = [
                'id'    => $email->getId(),
                'email' => $email->getEmail(),
            ];
        }

        return [
            'members' => $members,
            'total'   => count($members),
        ];
    }
}
