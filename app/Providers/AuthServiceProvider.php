<?php

namespace App\Providers;

use App\Answer;
use App\Question;
use App\Policies\Answerpolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => Answerpolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Gate::define('update-question', function($user, $question){
            return $user->id == $question->user_id;
        });

        \Gate::define('delete-question', function($user, $question){
            return $user->id == $question->user_id;
        });
    }
}
