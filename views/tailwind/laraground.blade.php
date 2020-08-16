@extends('vendor.laraground.tailwind.layout', ['class' => 'h-full bg-gray-900'])

@section('body')
    <div class="bg-gray-100 flex flex-col h-full">

        <div class="bg-yellow-700 text-yellow-100 p-4 uppercase font-bold tracking-wider">Laraground</div>
        @livewire('laraground.laraground')

    </div>
@endsection

@push('styles')
    <style></style>
@endpush

@push('scripts')
    <script>
        function simpleStringify(object) {
            let simpleObject = {};
            for (let prop in object) {
                if (!object.hasOwnProperty(prop)) {
                    continue;
                }
                if (typeof (object[prop]) === 'object') {
                    let _obj;
                    try {
                        _obj = JSON.stringify(object[prop]);
                        _obj = object[prop];
                    } catch (e) {
                        _obj = '[Object]';
                    }
                    simpleObject[prop] = _obj;
                    continue;
                }
                if (typeof (object[prop]) === 'function') {
                    simpleObject[prop] = '[Closure]';
                    continue;
                }
                simpleObject[prop] = object[prop];
            }
            // return simpleObject;
            return JSON.stringify(simpleObject);
        }

        console.defaultLog = console.log.bind(console);
        console.logs = [];
        console.log = function () {
            console.defaultLog.apply(console, arguments);
            window.livewire.emit('consoleLog', JSON.stringify(arguments));

            const lgConsole = document.querySelector('#lg-console');
            setTimeout(function () {
                lgConsole.scrollTo(0, lgConsole.scrollHeight)
            }, 50);
        }

        // const handler = document.querySelector('#handleResizeWindow');
        // let resizing = false, lastYresized = 0;
        // handler.addEventListener('mousedown', function () {
        //     console.log('init resize');
        //     resizing = true;
        //
        //     // var offsetRight = container.width() - (e.clientX - container.offset().left);
        // })
        // document.addEventListener('mousemove', function () {
        //     if (!resizing) {
        //         return;
        //     }
        //
        //     console.log('resizeing');
        //
        // })
        // document.addEventListener('mouseup', function () {
        //     console.log('end resize');
        //     resizing = false;
        // })
    </script>
@endpush
