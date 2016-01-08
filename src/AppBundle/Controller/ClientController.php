<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ApiClientService;
use Symfony\Component\Form\FormError;

/**
 * Description of ClientController
 *
 * @author Ilie
 */
class ClientController extends Controller
{
    public function createArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $apiService = $this->get(ApiClientService::SERVICE_NAME);
        $form = $this->createForm(new \AppBundle\Form\ArticleType($userRepository));
        if ($request->isMethod('POST')) {
            $response = $apiService->createArticle($request->request->all());
            $arrayResponse = json_decode($response, true);
            if (200 !== $arrayResponse['code']) {
                if (isset($arrayResponse['errors']['children'])) {
                    foreach ($arrayResponse['errors']['children'] as $key => $value) {
                        if (isset($value['errors']))
                            $form->get($key)->addError(new FormError($value['errors'][0]));
                    }
                }
            } else {
                return $this->redirect($this->generateUrl('client_article'));
            }
        }
        
        return $this->render('default/create_article.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
