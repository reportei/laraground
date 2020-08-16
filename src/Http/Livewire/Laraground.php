<?php

namespace App\Http\Livewire\Laraground;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use ReflectionClass;
use ReflectionProperty;

class Laraground extends Component
{
    public $attributes = [];
    public $components = [];
    public $componentView = null;
    public $componentConfig = null;
    public $consoleLogs = [];
    protected $component = null;
    protected $listeners = ['consoleLog' => 'addConsoleLog'];

    public function mount()
    {
        $classes = [
            'root' => [],
            'grouped' => [],
        ];
        $paths = [app_path('View/Components')];

        foreach($paths as $path) {
            $views = File::allFiles($path);
            foreach ($views as $view) {
                $desc = str_replace(['.php', '/'], ['', '\\'], $view->getRelativePathname());
                $className = 'App\\View\\Components\\' . $desc;
                $class = new ReflectionClass($className);
                if (!$class->hasMethod('laraground')) {
                    continue;
                }

                $desc = str_replace('\\', '/', optional((object)$class->getDefaultProperties())->lgDesc ?? $desc);
                $descs = explode('/', $desc, 2);

                if (!isset($descs[1])) {
                    $classes['root'][] = [
                        'class' => str_replace('\\', '/', $className),
                        'desc' => $desc,
                    ];
                    continue;
                }

                if (!isset($classes['grouped'][$descs[0]])) {
                    $classes['grouped'][$descs[0]] = [];
                }
                $classes['grouped'][$descs[0]][] = [
                    'class' => str_replace('\\', '/', $className),
                    'desc' => $descs[1],
                ];
            }
        }

        $this->components = $classes;
    }

    public function viewComponent($className)
    {
        $className = str_replace('/', '\\', $className);
        $class = new ReflectionClass($className);
        $classAsArray = explode('\\', $className);
        $view = optional((object)$class->getDefaultProperties())->lgView ?? 'x-form.' . Str::slug(array_pop($classAsArray));

        $this->component = $class;
        $this->componentView = $view;
        $newAttributes = [];

        $attributes = $class->getProperties(ReflectionProperty::IS_PUBLIC);
        $defaultAttributes = (object)$class->getDefaultProperties();
        $ignored = ['componentName', 'attributes'];
        foreach ($attributes as $attribute) {
            $name = $attribute->getName();
            if (in_array($name, $ignored)) {
                continue;
            }
            $newAttributes[$name] = optional($defaultAttributes)->$name ?? '';
        }

        $this->attributes = $newAttributes;
        $this->componentConfig = $className::laraground();
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function addConsoleLog($message)
    {
        $this->consoleLogs[Carbon::now()->format('d/m/Y h:i:s')] = (array)json_decode($message);
    }

    public function isValidJson($value)
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function render()
    {
        return view('vendor.laraground.tailwind.livewire.laraground');
    }
}
