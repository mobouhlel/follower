<?php
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 01:04
 */

namespace Follower\TwitterBundle\Service\Factory;

use Follower\CoreBundle\Interfaces\SearchInterface;
use Follower\TwitterBundle\Parser\SearchParser;
use Follower\TwitterBundle\Service\AbstractService;

class Search extends AbstractService implements SearchInterface
{
    public function search($query)
    {
        $result = $this->client->request('GET', $this->getSearchUrl($query), array(), array(), array(
            'HTTP_USER_AGENT' => $this->getUserAgent()
        ));

        return SearchParser::parse($result);
    }
}