<?php

namespace App\Services;

use App\Contracts\Services\GraphServiceInterface;
use App\Contracts\Services\SurveyServiceInterface;

class GraphService implements GraphServiceInterface
{
    private SurveyServiceInterface $service;

    public function __construct(SurveyServiceInterface $service)
    {
        $this->service = $service;
    }
}
