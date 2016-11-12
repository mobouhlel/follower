<?php

namespace Follower\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FollowerCoreBundle:Default:index.html.twig');
    }
}
