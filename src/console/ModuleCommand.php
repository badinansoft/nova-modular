<?php

namespace Badinansoft\NovaModular\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModuleCommand extends Command
{
    use ResolvesStubPath;


    protected $signature = 'nova:module {name}';

    protected $description = 'Create a new module in nova';

    public function handle(): void
    {
        $this->comment('Creating Folder for module ...');

        (new Filesystem)->copyDirectory(
            __DIR__.'/stubs/module-stubs',
            $this->modulePath()
        );

        $this->comment('Generating Resource class...');
        $this->replace('{{ namespace }}', $this->componentNamespace(), $this->modulePath().'/resource.stub');
        $this->replace('{{ class }}', $this->componentClass(), $this->modulePath().'/resource.stub');
        $this->replace('{{ namespacedModel }}', $this->namespaceModel(), $this->modulePath().'/resource.stub');

        (new Filesystem)->move(
            $this->modulePath().'/resource.stub',
            $this->modulePath().'/'.$this->componentClass().'.php'
        );



        $this->comment('Generating Resource Fields class ...');
        $this->replace('{{ namespace }}', $this->fieldsNamespace(), $this->modulePath().'/Fields/resource-fields.stub');
        $this->replace('{{ resource }}', $this->componentClass(), $this->modulePath().'/Fields/resource-fields.stub');

        (new Filesystem)->move(
            $this->modulePath().'/Fields/resource-fields.stub',
            $this->modulePath().'/Fields/'.$this->componentClass().'Fields.php'
        );


        $this->comment('Generating Action Traits...');
        $this->replace('{{ resource }}', $this->componentClass(), $this->modulePath().'/Traits/action-registration.stub');
        $this->replace('{{ namespace }}', $this->TraitsNamespace(), $this->modulePath().'/Traits/action-registration.stub');

        (new Filesystem)->move(
            $this->modulePath().'/Traits/action-registration.stub',
            $this->modulePath().'/Traits/'.$this->componentActionTrait().'.php'
        );


        $this->comment('Generating Card Traits...');
        $this->replace('{{ resource }}', $this->componentClass(), $this->modulePath().'/Traits/card-registration.stub');
        $this->replace('{{ namespace }}', $this->TraitsNamespace(), $this->modulePath().'/Traits/card-registration.stub');

        (new Filesystem)->move(
            $this->modulePath().'/Traits/card-registration.stub',
            $this->modulePath().'/Traits/'.$this->componentCardTrait().'.php'
        );

        $this->comment('Generating Lenses Traits...');
        $this->replace('{{ resource }}', $this->componentClass(), $this->modulePath().'/Traits/lenses-registration.stub');
        $this->replace('{{ namespace }}', $this->TraitsNamespace(), $this->modulePath().'/Traits/lenses-registration.stub');

        (new Filesystem)->move(
            $this->modulePath().'/Traits/lenses-registration.stub',
            $this->modulePath().'/Traits/'.$this->componentLensesTrait().'.php'
        );

        $this->comment('Generating Filters Traits...');
        $this->replace('{{ resource }}', $this->componentClass(), $this->modulePath().'/Traits/filters-registration.stub');
        $this->replace('{{ namespace }}', $this->TraitsNamespace(), $this->modulePath().'/Traits/filters-registration.stub');

        (new Filesystem)->move(
            $this->modulePath().'/Traits/filters-registration.stub',
            $this->modulePath().'/Traits/'.$this->componentFiltersTrait().'.php'
        );

        $this->info('Resource created successfully.');
    }

    protected function replace($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    private function moduleName(){
        return $this->argument('name');
    }

    private function componentName():string
    {
        return explode('/', $this->moduleName())[0];
    }

    private function componentClass():string
    {
        return Str::studly($this->componentName());
    }

    private function componentNamespace(): string
    {
        return Str::studly('App\Nova\Modules\\'.$this->componentClass());
    }

    private function namespaceModel(): string
    {
        return Str::studly('App\Models\\'.$this->componentClass().'::class');
    }

    private function componentVendor(): string
    {
        return explode('/', $this->moduleName())[0];
    }

    private function modulePath(){
        return app_path('Nova/Modules/'.$this->moduleName());
    }

    private function componentActionTrait(): string
    {
        return Str::studly('Has'.$this->componentClass().'Actions');
    }

    private function componentCardTrait(): string
    {
        return Str::studly('Has'.$this->componentClass().'Cards');
    }

    private function componentLensesTrait(): string
    {
        return Str::studly('Has'.$this->componentClass().'Lenses');
    }

    private function componentFiltersTrait(): string
    {
        return Str::studly('Has'.$this->componentClass().'Filters');
    }

    private function TraitsNamespace(): string
    {
        return Str::studly('App\Nova\Modules\\'.$this->componentClass().'\Traits');
    }

    private function fieldsNamespace(): string
    {
        return Str::studly('App\Nova\Modules\\'.$this->componentClass().'\Fields');
    }

}
