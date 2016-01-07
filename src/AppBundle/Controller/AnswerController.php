<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\ArticleAnswer;
use AppBundle\Form\ArticleAnswerType;

/**
 * @author Ilie
 */
class AnswerController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Create a new Answer",
     *  input="AppBundle\Form\ArticleAnswerType",
     *  output="AppBundle\Entity\AnswerArticle"
     * )
     * @Rest\View
     */
    public function postAnswerAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $articleRepository = $em->getRepository('AppBundle:Article');
        $answer = new ArticleAnswer();

        $form = $this->createForm(
            new ArticleAnswerType($userRepository, $articleRepository), 
            $answer
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em->persist($answer);
            $em->flush();
            return array('answer' => $answer);
        } else {
            return $form;
        }
    }
}