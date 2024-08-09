<?php

namespace App\Http\Contracts;

interface ProjectServiceContract {

    public function logProjectImpression(array $project_ids);
}