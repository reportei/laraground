Just add config in View Component Class
```
class Button extends Component
{
    ...
    protected $lgDesc = 'Form/Button';
    protected $lgView = 'components.form.button';
    
    ...
    public static function laraground()
    {
        return [
            'attributes' => [
                'label' => 'Button',
                'type' => 'button',
                'color' => 'primary',
                'size' => 'md',
            ],
            'slots' => [
                'slot' => 'label' // targint label attribute for control binds
            ],
            'model' => '' // wire:model when is input, select or textarea
                          // see https://laravel-livewire.com/docs/data-binding/
        ];
    }
}
```
