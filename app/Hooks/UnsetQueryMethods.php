<?php

declare(strict_types=1);

namespace App\Hooks;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;

class UnsetQueryMethods implements ModelHookInterface
{
    public function run(ModelsCommand $modelsCommand, Model $model): void
    {
        $modelsCommand->unsetMethod('newModelQuery');
        $modelsCommand->unsetMethod('newQuery');
        $modelsCommand->unsetMethod('query');
        $modelsCommand->unsetMethod('factory');
    }
}
