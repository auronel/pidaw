<div>
    @if($accion=="create" || $accion=="edit")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            @if($accion=="create")
            <div class="text-center font-bold">
                {{ __('Añadir mascota') }}
            </div>
            @else
            <div class="text-center font-bold">
                {{ __('Editar mascota') }}
            </div>

            @endif
            @if ($errors->any())
            <div class="max-w-sm mx-auto py-6">
                <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="bg-gray-50 overflow-hidden shadow-md sm:rounded-lg py-4">
                <div class="max-w-sm mx-auto px-2">
                    <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                    <x-jet-input wire:model="nombre" id="nombre" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-sm mx-auto px-2">
                    <x-jet-label for="tipo" value="{{ __('Tipo') }}" />
                    <select wire:model="tipo" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                        <option value="null" disabled>Elige una opción</option>
                        <option value="Perro">Perro</option>
                        <option value="Gato">Gato</option>
                        <option value="Reptil">Reptil</option>
                        <option value="Ave">Ave</option>
                        <option value="Roedor">Roedor</option>
                    </select>
                </div>

                <div class="mt-4 max-w-sm mx-auto px-2">
                    <x-jet-label for="raza" value="{{ __('Raza') }}" />
                    <x-jet-input wire:model="raza" id="apellidos" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-sm mx-auto px-2">
                    <x-jet-label for="edad" value="{{ __('Edad') }}" />
                    <x-jet-input wire:model="edad" id="telefono" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-sm mx-auto px-2">
                    <x-jet-label for="sexo" value="{{ __('Sexo') }}" />
                    <select wire:model="sexo" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                        <option value="null" disabled>Elige una opción</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <div class="mt-2 text-center">
                @if($accion=="create")
                <x-jet-button wire:click="store">{{ __('Añadir') }}</x-jet-button>
                @else
                <x-jet-button wire:click="update">{{ __('Actualizar') }}</x-jet-button>
                @endif
                <x-jet-danger-button wire:click="resetear">{{ __('Cancelar') }}</x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- Información de la mascota --}}
    @if($accion=="info")
    <x-jet-dialog-modal wire:model="modal" maxWidth="7xl">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Historial de la mascota '. $nombre) }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="text-gray-500 text-center p-4">
                <p><span class="text-gray-900 font-bold">Dueño de la mascota: </span>{{ $usuario['name'].' '.$usuario['apellidos'] }}</p>
                <p><span class="text-gray-900 font-bold">DNI: </span>{{ $usuario['dni'] }}</p>
            </div>
            <div class="w-full bg-gray-50 text-gray-600 shadow-md rounded-lg p-4">
                <div>
                    @if($informes->count())
                    @foreach($informes as $informe)
                    <div class="w-full py-3">
                        <h2 class="font-bold pb-2 uppercase">{{ $informe->titulo }}</h2>
                        <ul>
                            <li class="text-gray-600">{{ $informe->descripcion }}</li>
                        </ul>
                    </div>
                    @endforeach
                    @else
                    <div class="text-gray-500 text-center p-4">
                        <p>La mascota no tiene ningun informe actualmente</p>
                    </div>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <x-jet-button wire:click="nuevoInforme">{{ __('Nuevo informe') }}</x-jet-button>
                <x-jet-danger-button wire:click="resetear">{{ __('Salir') }}</x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    @if($accion=="delete")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Eliminar mascota') }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="bg-gray-50 shadow-md rounded-lg text-center p-4">
                <p>¿Deseas eliminar a la mascota <span class="font-bold">{{ $nombre }}</span>?</p>
                <p><span class="text-gray-900 font-bold">Dueño: </span>{{ $usuario['name'].' '.$usuario['apellidos'] }}</p>
                <p><span class="text-gray-900 font-bold">DNI: </span>{{ $usuario['dni'] }}</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <x-jet-danger-button wire:click="destroy({{ $mascota }})">Eliminar</x-jet-danger-button>
                <x-jet-button wire:click="resetear">{{ __('Salir') }}</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- Tabla de mascotas --}}
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2 ml-2">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-indigo-500">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <x-jet-input wire:model.debounce.500ms="search" type="search" class="pl-10 ml-2" autocomplete="off"></x-jet-input>
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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-3">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if($mascotas->count())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tipo
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Raza
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Edad
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Sexo
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($mascotas as $mascota)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $mascota->nombre }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $mascota->tipo }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $mascota->raza }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $mascota->edad }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $mascota->sexo }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                                <button wire:click="show({{ $mascota }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-eye"></i></button>
                                                <button wire:click="edit({{ $mascota }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-edit"></i></button>
                                                <button wire:click="fdelete({{ $mascota }})" class="text-indigo-600 hover:text-indigo-900  focus:outline-none"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="border-t border-gray-200 p-5">
                                    {{ $mascotas->links() }}
                                </div>
                            </div>
                            @else
                            <p class="text-sm text-gray-900 p-6">No hay resultados para la busqueda {{ $search }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
