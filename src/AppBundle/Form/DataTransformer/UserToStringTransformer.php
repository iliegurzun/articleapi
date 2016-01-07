<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserToStringTransformer implements DataTransformerInterface
{
    private $repository;

    public function __construct(EntityRepository $repository = null)
    {
        $this->repository = $repository;
    }

    /**
     * Transforms an object (user) to a string (username).
     *
     * @param  User|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return '';
        }

        return $user->getUsername();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $username
     * @return User|null
     * @throws TransformationFailedException if object (user) is not found.
     */
    public function reverseTransform($username)
    {
        // no username? It's optional, so that's ok
        if (!$username) {
            return;
        }

        $user = $this->repository->findOneByUsername($username)
        ;

        if (null === $user) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An user with username %s does not exist!',
                $username
            ));
        }

        return $user;
    }
}
