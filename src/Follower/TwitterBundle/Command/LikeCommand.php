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

   // nohup app/console twitter:like:command > logs/twitter.like.command & nohup app/console twitter:follow:command > logs/twitter.follow.command &  nohup app/console twitter:unfollow:command > logs/twitter.unfollow.command & nohup app/console twitter:reshare:command > logs/twitter.reshare.command &  nohup app/console twitter:messagesender:command > logs/twitter.messagesender.command &
}