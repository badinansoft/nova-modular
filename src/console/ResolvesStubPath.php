<?php

namespace Badinansoft\NovaModular\console;

trait ResolvesStubPath
{
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.str_replace('nova/', '', $stub);
    }
}