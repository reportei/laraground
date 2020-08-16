<div class="flex h-full">
    <div class="bg-gray-200 w-1/5 border-r shadow">

        @foreach($components['grouped'] as $namespace => $children)
            <div class="">
                <div x-data
                     @click="console.log($refs.teste.innerHTML, 123, 'abc', {a: 123}, ['iga', 'aeae'])"
                     x-ref="teste" class="font-bold p-4 bg-gray-300">{{$namespace}}</div>
                <div class="">
                    @foreach($children as $component)
                        <div wire:click="viewComponent('{{$component['class']}}')"
                             class="py-3 px-8 border-b bg-gray-100 hover:bg-gray-200 cursor-pointer">
                            {{$component['desc']}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
    <div class="w-4/5 justify-between flex flex-col">
        <div class="bg-white flex-1 overflow-y-auto">

            <div class="p-4">

                @if ($componentView && $componentConfig)
                    @component($componentView, $componentConfig['methods'] + $componentConfig['attributes'] + ['attributes' => $componentBag->merge($componentConfig['attributes'])])
                        @if (count($componentConfig['slots']))
                            @foreach ($componentConfig['slots'] as $slotName => $slot)
                                @slot($slotName)
                                    {!! $componentConfig['attributes'][$slot] !!}
                                @endslot
                            @endforeach
                        @endif
                    @endcomponent
                @endif

            </div>
        </div>

        <div x-data="{tabSelected: ''}" class="border-t">
            {{--            <hr id="handleResizeWindow"--}}
            {{--                style="cursor: ns-resize"--}}
            {{--                class="border-2 hover:border-blue-300 border-solid hover:border-dashed"/>--}}
            <div class="flex justify-between">
                <div class="flex">
                    @if ($componentConfig)
                        <div class="border-r px-4 py-2 cursor-pointer hover:bg-gray-300"
                             @click="tabSelected = 'component'"
                             x-bind:class="{'bg-gray-800 hover:bg-gray-700 text-white': tabSelected === 'component'}">Component
                        </div>
                    @endif
                    <div class="border-r px-4 py-2 cursor-pointer hover:bg-gray-300"
                         @click="tabSelected = 'console'"
                         x-bind:class="{'bg-gray-800 hover:bg-gray-700 text-white': tabSelected === 'console'}">Console
                    </div>
                </div>
                <div class="flex items-center justify-center px-4 py-2 cursor-pointer text-gray-800 hover:text-red-700"
                     @click="tabSelected = ''">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div>
                <div class="bg-gray-200 shadow"
                     x-bind:class="{'flex h-70': tabSelected === 'component'}" x-cloak
                     x-show="tabSelected === 'component'">
                    @if ($componentConfig)
                        <div class="w-1/2 border-r overscroll-auto overflow-auto h-70">
                            @foreach($componentConfig['attributes'] as $attribute => $value)
                                <div class="px-4 py-2 flex items-center hover:bg-gray-300">
                                    <label for="label" class="w-1/12 uppercase text-xs">{{$attribute}}</label>
                                    <input type="text" wire:model="componentConfig.attributes.{{$attribute}}"
                                           value="{{$value}}" class="px-4 py-1 rounded flex-1">
                                </div>
                            @endforeach

                            <hr class="my-2"/>

                            @foreach($componentConfig['slots'] as $attribute => $value)
                                <div class="px-4 py-2 flex items-center hover:bg-gray-300">
                                    <label for="label" class="w-1/12 uppercase text-xs">{{$attribute}}</label>
                                    <input type="text" wire:model="componentConfig.attributes.{{$attribute}}"
                                           value="{{$value}}" class="px-4 py-1 rounded flex-1">
                                </div>
                            @endforeach
                        </div>
                        <div class="w-1/2 overscroll-auto overflow-auto bg-black text-white h-70">
                            <pre class="text-xs p-4"><code>{{print_r($componentConfig, 1)}}</code></pre>
                        </div>
                    @endif
                </div>
                <div id="lg-console" x-show="tabSelected === 'console'" class="overscroll-auto overflow-auto h-70"
                     x-cloak>
                    @foreach($consoleLogs as $log)
                        <div class="px-4 py-2 border-b text-xs leading-none">
                            <pre>{!! count($log) > 1 ? print_r($log, 1) : print_r($log[0], 1) !!}</pre>
                        </div>
                        {{--                        <div class="px-4 py-2 border-b text-xs leading-none"><pre>{!! print_r(count($log), 1) !!}</pre></div>--}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


