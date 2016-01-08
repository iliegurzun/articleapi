<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Service\UserNotification;

/**
 * Description of UserNotificationsCommand
 *
 * @author Ilie
 */
class UserNotificationsCommand extends ContainerAwareCommand
{
    const HOURS_AGO = 'hoursAgo';
    
    protected function configure()
    {
        
        $this
            ->setName('app:send_notifications')
            ->addOption(
               self::HOURS_AGO,
               null,
               InputOption::VALUE_OPTIONAL,
               'number of hours ago',
               24
            )
            ->setDescription('send an email to the writer of an article if he has notifications from more than x hours')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $service = $container->get(UserNotification::SERVICE_NAME);
        $service->notifyUsers($input->getOption(self::HOURS_AGO));
    }
}
