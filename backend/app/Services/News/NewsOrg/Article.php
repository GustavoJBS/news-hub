<?php

namespace App\Services\News\NewsOrg;

use App\Services\News\Client;

class Article extends Client
{
    public function get(?string $sources = null): mixed
    {
        $query = [];

        if ($sources) {
            $query['sources'] = $sources;
        }

        return $this->api
            ->get('everything', $query)
            ->json();
    }
}