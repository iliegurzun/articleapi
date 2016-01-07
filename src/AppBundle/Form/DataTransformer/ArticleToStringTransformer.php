<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArticleToStringTransformer implements DataTransformerInterface
{
    private $repository;

    public function __construct(EntityRepository $repository = null)
    {
        $this->repository = $repository;
    }

    /**
     * Transforms an object (article) to a string (slug).
     *
     * @param  Article|null $user
     * @return string
     */
    public function transform($article)
    {
        if (null === $article) {
            return '';
        }

        return $article->getSlug();
    }

    /**
     * Transforms a string (slug) to an object (article).
     *
     * @param  string $slug
     * @return Article|null
     * @throws TransformationFailedException if object (article) is not found.
     */
    public function reverseTransform($slug)
    {
        // no article slug? It's optional, so that's ok
        if (!$slug) {
            return;
        }

        $article = $this->repository->findOneBySlug($slug)
        ;

        if (null === $article) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'The article %s does not exist!',
                $slug
            ));
        }

        return $article;
    }
}
