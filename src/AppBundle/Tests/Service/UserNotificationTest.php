<?php

namespace AppBundle\Tests\Service;

use AppBundle\Tests\AbstractTest;
/**
 * Description of ApiClientServiceTest
 *
 * @author Ilie
 */
class UserNotificationTest extends AbstractTest
{
    public function testEntity()
    {
        $service = $this->container->get(\AppBundle\Service\UserNotification::SERVICE_NAME);
        $this->assertInstanceof(\Doctrine\ORM\EntityManager::class, $service->getEntityManager());
        $this->assertInstanceof(\Twig_Environment::class, $service->getTwig());
        $this->assertInstanceof(\Swift_Mailer::class, $service->getMailer());
    }
}