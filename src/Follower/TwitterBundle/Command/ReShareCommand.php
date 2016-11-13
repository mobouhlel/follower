<?php
namespace Follower\TwitterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReShareCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('twitter:reshare:command')
            ->setDescription('Follow twitter.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $container->get('twitter_resharer')->share();
    }
}