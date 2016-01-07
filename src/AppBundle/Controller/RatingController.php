<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\ArticleRating;
use AppBundle\Form\ArticleRatingType;

/**
 * @author Ilie
 */
class RatingController extends FOSRestController
{   
    /**
     * @ApiDoc(
     *  description="Create a new Rating",
     *  input="AppBundle\Form\ArticleRatingType",
     *  output="AppBundle\Entity\ArticleRating"
     * )
     * @Rest\View
     */
    public function postRatingAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $articleRepository = $em->getRepository('AppBundle:Article');
        $rating = new ArticleRating();

        $form = $this->createForm(
            new ArticleRatingType($userRepository, $articleRepository),
            $rating
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em->persist($rating);
            $em->flush();
            return array('rating' => $rating);
        } else {
            return $form;
        }
    }
}
