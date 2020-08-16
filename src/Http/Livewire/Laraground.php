<?php

namespace App\Http\Livewire\Laraground;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Livewire\Component;
use ReflectionClass;
use ReflectionProperty;
use ReflectionException;

/**
 * Class Laraground
 * @package App\Http\Livewire\Laraground
 */
class Laraground extends Component
{
    public $attributes = [];
    public $components = [];
    public $componentName = null;
    public $componentView = null;
    public $componentConfig = null;
    public $consoleLogs = [];
    protected $component = null;
    protected $listeners = ['consoleLog' => 'addConsoleLog'];

    /**
     * @throws \ReflectionException
     */
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

    /**
     * @param $className
     * @throws ReflectionException
     */
    public function viewComponent($className)
    {
        $className = str_replace('/', '\\', $className);
        $class = new ReflectionClass($className);
        $classAsArray = explode('\\', $className);
        $view = optional((object)$class->getDefaultProperties())->lgView ?? 'x-form.' . Str::slug(array_pop($classAsArray));

        $this->componentName = $className;
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
        if (!isset($this->componentConfig['methods'])) {
            $this->componentConfig['methods'] = [];
        }
    }

    /**
     * @return |null
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param $message
     */
    public function addConsoleLog($message)
    {
        $this->consoleLogs[Carbon::now()->format('d/m/Y h:i:s')] = (array)json_decode($message);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValidJson($value)
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $componentBag = new ComponentAttributeBag($this->attributes);
        if ($this->componentName && count($this->componentConfig['methods'])) {
            $className = $this->componentName;
            $componentConfig = $className::laraground();
            $this->componentConfig['methods'] = $componentConfig['methods'];
        }
        return view('vendor.laraground.tailwind.livewire.laraground', compact('componentBag'));
    }
}
