<?php
namespace Follower\TwitterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LikeCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('twitter:like:command')
            ->setDescription('Like twitter.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $container->get('twitter_liker')->like();
    }
}