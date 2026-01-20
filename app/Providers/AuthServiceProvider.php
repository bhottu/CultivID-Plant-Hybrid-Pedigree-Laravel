<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\PlantSubmission;
use App\Policies\PlantSubmissionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PlantSubmission::class => PlantSubmissionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
