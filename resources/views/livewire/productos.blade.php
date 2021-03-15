<div class="bg-white">
    <div class="bg-white">
        @if(auth()->user()->rol=="Administrador")
        <div class="text-center pt-6">
            <x-jet-button wire:click="create">{{ __('Añadir producto') }}</x-jet-button>
        </div>
        @endif
        @if($accion=="create" || $accion=="edit")
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                @if($accion=="create")
                <div class="text-center font-bold">
                    {{ __('Nuevo Producto') }}
                </div>
                @else
                <div class="text-center font-bold">
                    {{ __('Editar Producto') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </x-slot>
            <x-slot name="content">
                <div class="bg-gray-50 text-gray-600 shadow-md rounded-lg p-4 mx-auto">
                    <div class="mt-4">
                        <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                        <x-jet-input wire:model="nombre" id="nombre" class="block mt-1 w-full" type="text" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="precio" value="{{ __('Precio') }}" />
                        <x-jet-input wire:model="precio" id="precio" class="block mt-1 w-full" type="number" min="0" step="0.01" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="categoria" value="{{ __('Categoria') }}" />
                        <select wire:model="categoria" id="categoria" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            <option value="null" disabled>Elige una opción</option>
                            @foreach($categorias as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="descripcion" value="{{ __('Descripcion') }}" />
                        <textarea wire:model="descripcion" class="resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" rows="6"></textarea>
                    </div>

                    @if($accion=="edit")
                    <div class="mt-2">
                        <img class="w-20 h-20 mt-2" src="storage/productos/{{ $imagen }}" alt="{{ $nombre }}">
                    </div>
                    @endif

                    <div class="mt-4">
                        <x-jet-label for="foto" value="{{ __('Foto') }}" />
                        <x-jet-input wire:model="foto" id="foto" class="block mt-1 w-full" type="file" autofocus />
                    </div>

                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="text-center">
                    @if($accion=="create")
                    <x-jet-button wire:click="store">{{ __('Añadir') }}</x-jet-button>
                    @else
                    <x-jet-button wire:click="update">{{ __('Actualizar') }}</x-jet-button>
                    @endif
                    <x-jet-danger-button wire:click="resetear">{{ __('Salir') }}</x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        @endif
        @if($accion=="delete")
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                <div class="text-center font-bold">
                    {{ __('Eliminar producto') }}
                </div>

            </x-slot>
            <x-slot name="content">
                <div class="bg-gray-50 shadow-md rounded-lg text-center p-4">
                    <p>¿Deseas eliminar el producto <span class="font-bold">{{ $nombre }}</span>?</p>
                    <img class="my-2 mx-auto" src="storage/productos/{{ $foto }}" style="height: 16rem;">
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="text-center">
                    <x-jet-danger-button wire:click="destroy({{ $producto }})">Eliminar</x-jet-danger-button>
                    <x-jet-button wire:click="resetear">{{ __('Salir') }}</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        @endif
    </div>

    <div class="max-w-7xl mx-auto text-center">

        <div class="p-4">
            <select wire:model="categoriaSearch" id="categoria" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $value)
                <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            <select wire:model="precioSearch" id="precioSearch" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-2">
                <option value="1">Todos los precios</option>
                <option value="2">1€ - 25€</option>
                <option value="3">25€ - 50€</option>
                <option value="4">50€ - 100€</option>
            </select>
        </div>

        @if(session('mensaje'))
        <div x-data="{ open: true }" class="max-w-xl mx-auto mt-4">
            <div x-show="open" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('mensaje') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg @click="open = false" class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20">
                        <title>Cerrar</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
        </div>
        @elseif(session('eliminar'))
        <div x-data="{ open: true }" class="max-w-xl mx-auto mt-4">
            <div x-show="open" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('eliminar') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg @click="open = false" class="fill-current h-6 w-6 text-red-500" role="button" viewBox="0 0 20 20">
                        <title>Cerrar</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
        </div>
        @endif

        @if($productos->count())
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 justify-items-center px-4 overflow-hidden">
            @foreach($productos as $producto)
            <div class="max-w-sm shadow-xl rounded-lg mt-8 bg-gray-50 p-4">
                <div class="py-2" style="height: 10rem;">
                    <h2 class="text-gray-900 font-bold text-sm text-center uppercase">{{ $producto->nombre }}</h2>
                    <p class="text-gray-600 text-sm my-2">{{ $producto->descripcion }}</p>
                </div>
                <img class="my-2 mx-auto" src="storage/productos/{{ $producto->foto }}" style="height: 16rem;">
                <div class="py-2 bg-indigo-300">
                    <h3 class="text-white font-bold text-xl text-center">{{ $producto->precio }} €</h3>
                </div>
                @if(auth()->user()->rol=="Administrador")
                <div class="text-center py-3">
                    <button class="text-indigo-600 mr-2 focus:outline-none" wire:click="edit({{ $producto }})"><i class="far fa-edit"></i></button>
                    <button class="text-indigo-600 focus:outline-none" wire:click="fdelete({{ $producto }})"><i class="far fa-trash-alt"></i></button>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @else
        <p class="text-sm text-gray-900 p-3">No hay resultados para la categoría {{ $categoriaSearch }}</p>
        @endif

        <div class=" bg-white py-4 px-11">
            {{ $productos->links() }}
        </div>

    </div>

</div>
