<?php

namespace Follower\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FollowerTwitterBundle:Default:index.html.twig');
    }
}
