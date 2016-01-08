<?php

namespace AppBundle\Service;

/**
 * Description of UserNotification
 *
 * @author Ilie
 */
class UserNotification 
{
    const SERVICE_NAME = 'app.user_notification';
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     *
     * @var \Twig_Environment
     */
    protected $twig;
    
    /**
     *
     * @var \Swift_Mailer
     */
    protected $mailer;


    protected function sendEmail($params)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('Hello '.$params['username'])
        ->setFrom('ilie.gurzun@gmail.com')
        ->setTo($params['email'])
        ->setBody(
            $this->getTwig()->render(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/notification.html.twig',
                array('username' => $params['username'])
            ),
            'text/html'
        )
        ;
        $this->getMailer()->send($message);
    }
    
    public function notifyUsers($hoursAgo)
    {
        $date = new \DateTime();
        $date->modify("-$hoursAgo hours");
        $users = $this->retrieveUsers($date);
        if (!empty($users)) {
            foreach ($users as $user) {
                $params = array(
                    'username' => $user->getUsername(),
                    'email'    => $user->getEmail()
                );
                $this->sendEmail($params);
            }
        }
    }
    
    public function retrieveUsers($date)
    {
        $users = new \Doctrine\Common\Collections\ArrayCollection();
        $articleRepo = $this->getManager()->getRepository('AppBundle:Article');
        $articles = $articleRepo->findWithNotifications($date);
        
        foreach ($articles as $article) {
            if ($article->getAnswers()->count()) {
                foreach ($article->getAnswers() as $answer) {
                    if ($answer->getCreated() < $date && !$answer->getEmailSent()) {
                        if (!$users->contains($answer->getUser())) {
                            $users->add($answer->getUser());
                        }
                        $answer->setEmailSent(true);
                        $this->getEntityManager()->persist($answer);
                        $this->getEntityManager()->flush($answer);
                    }
                }
            }
            if ($article->getRatings()->count()) {
                foreach ($article->getRatings() as $rating) {
                    if ($rating->getCreated() < $date && $rating->getEmailSent()) {
                        if (!$users->contains($rating->getUser())) {
                            $users->add($rating->getUser());
                        }
                        $rating->setEmailSent(true);
                        $this->getEntityManager()->persist($rating);
                        $this->getEntityManager()->flush($rating);
                    }
                }
            }
        }
        
        return $users;
    }

        public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        
        return $this;
    }
    
    public function setTwig($twig)
    {
        $this->twig = $twig;
        
        return $this;
    }
    
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
        
        return $this;
    }
    
    public function getEntityManager()
    {
        return $this->entityManager;
    }
    
    public function getTwig()
    {
        return $this->twig;
    }
    
    public function getMailer()
    {
        return $this->mailer;
    }
}
