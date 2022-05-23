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
            __DIR__.'/module-stubs',
            $this->modulePath()
        );

        $this->comment('Generating Resource Name...');
        $this->replace('{{ namespace }}', $this->componentNamespace(), $this->componentPath().'/resource.stub');
        $this->replace('{{ class }}', $this->componentClass(), $this->componentPath().'/resource.stub');

        (new Filesystem)->move(
            $this->modulePath().'/resource.stub',
            $this->modulePath().'/'.$this->componentClass().'.php'
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
        return Str::studly($this->componentVendor()).'\\'.$this->componentClass();
    }

    private function componentVendor(): string
    {
        return explode('/', $this->moduleName())[0];
    }

    private function modulePath(){
        return app_path('Nova/Modules/'.$this->moduleName());
    }


}
