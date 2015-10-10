<?php

namespace App\Library\Shortener;

use App\Library\Exceptions\NonExistentHashException;
use App\Library\Repositories\LinkRepositoryInterface as LinkRepo;
use App\Library\Utilities\UrlHasher;
use Event;

class ShortenerService
{
    /**
     * @var \App\Library\Repositories\LinkRepositoryInterface
     */
    protected $linkRepo;

    /**
     * @var \App\Library\Utilities\UrlHasher
     */
    protected $urlHasher;

    /**
     * @param LinkRepo  $linkRepo
     * @param UrlHasher $urlHasher
     */
    public function __construct(LinkRepo $linkRepo, UrlHasher $urlHasher)
    {
        $this->linkRepo = $linkRepo;
        $this->urlHasher = $urlHasher;
    }

    /**
     * Fetch a url by hash
     *
     * @param $hash
     *
     * @return mixed
     * @throws \App\Library\Exceptions\NonExistentHashException
     */
    public function getUrlByHash($hash)
    {
        $link = $this->linkRepo->byHash($hash);

        if (!$link) {
            throw new NonExistentHashException;
        }

        $link->uses++;
        $link->save();

        return $link->url;
    }

    /**
     * Save url to the database and hash it.
     *
     * @param $url
     *
     * @return string
     */
    public function make($url)
    {
        if (substr($url, 0, 7) != 'http://' && substr($url, 0, 8) != 'https://') {
            $url = 'http://' . $url;
        }
        
        $link = $this->linkRepo->byUrl($url);

        return $link ? $link->hash : $this->makeHash($url);
    }

    /**
     * Prepare and save new url + hash
     *
     * @param $url
     * @returns string
     */
    private function makeHash($url)
    {
        $hash = $this->urlHasher->make($url);
        $data = compact('url', 'hash');

        Event::fire('link.creating', [$data]);

        $this->linkRepo->create($data);

        return $hash;
    }
}
