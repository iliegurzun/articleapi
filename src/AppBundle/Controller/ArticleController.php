<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

/**
 * @author Ilie
 */
class ArticleController extends FOSRestController
{
     /**
     * Get single Answer
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Answer for a given slug",
     *   output = "Ibw\DamamiBundle\Entity\Answer",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Answer is not found"
     *   }
     * )
     *
     * @Rest\View
     * @param string $id the Answer's slug
     *
     * @return Answer
     *
     * @throws NotFoundException when Article not exist
     */
    public function getArticleAction($slug)
    {
        $article = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findOneBySlug($slug);
        if (!$article) {
            throw $this->createNotFoundException('Article not found!');
        }
        
        return array('article' => $article);
    }
    
    /**
     * @ApiDoc(
     *  description="Create a new Article",
     *  input="AppBundle\Form\ArticleType",
     *  output="AppBundle\Entity\Article"
     * )
     * @Rest\View
     */
    public function postArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $article = new Article();

        $form = $this->createForm(new ArticleType($userRepository), $article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em->persist($article);
            $em->flush();
            return array('article' => $article);
        } else {
            return $form;
        }
    }
}
