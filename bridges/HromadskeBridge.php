<?php

class HromadskeBridge extends BridgeAbstract
{
    const NAME = 'Hromadske Bridge';
    const URI = 'https://hromadske.ua/news';
    const DESCRIPTION = 'All blog posts from Hromadske.';
    const MAINTAINER = 'llamasblade';
    const CACHE_TIMEOUT = 820;

    public function collectData()
    {
        $html = getSimpleHTMLDOM($this->getURI());
        // Since GQ don't want simple class scrapping, let's do it the hard way and ... discover content !
        $main = $html->find('.l-feed-list', 0);
        $limit = $this->getInput('limit') ?? 10;
        foreach ($main->find('article') as $link) {
            if (count($this->items) >= $limit) {
                break;
            }
            $date = $link->find('time', 0);
            $item = [];
            $item['title'] = $link->find('h3')[0]->innertext;
            $item['uri'] = $link->find('a')[0]->href;
            $item['uid'] = md5($item['uri']);
            $short_date = $date->datetime;
            $item['timestamp'] = strtotime($short_date);
            $this->items[] = $item;
        }
    }


}
