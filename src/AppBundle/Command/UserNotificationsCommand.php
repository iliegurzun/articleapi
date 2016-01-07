<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Description of UserNotificationsCommand
 *
 * @author Ilie
 */
class UserNotificationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        
        $this
            ->setName('app:send_notifications')
            ->setDescription('send an email to the writer of an article if he has notifications from more than x hours')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
    }
}
