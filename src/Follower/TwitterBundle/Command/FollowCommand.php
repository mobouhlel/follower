<?php
namespace Follower\TwitterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FollowCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('twitter:follow:command')
            ->setDescription('Follow twitter.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $container->get('twitter_follower')->follow();
    }
}