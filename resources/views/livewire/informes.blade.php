<div>
    @if($accion=="create" || $accion=="edit")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            @if($accion=="create")
            <div class="text-center font-bold">
                {{ __('Nuevo informe') }}
            </div>
            @else
            <div class="text-center font-bold">
                {{ __('Editar informe') }}
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
            <div class="px-2">
                <x-jet-label for="titulo" value="{{ __('Título') }}" />
                <x-jet-input wire:model="titulo" id="titulo" class="block mt-1 w-full" type="text" required />
            </div>

            <div class="px-2 mt-4">
                <x-jet-label for="descripcion" value="{{ __('Descripción') }}" />
                <textarea wire:model="descripcion" class="resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" rows="6"></textarea>
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

    {{-- Datos del informe --}}
    @if($accion=="info")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Informe de la mascota '. $mascota['nombre']) }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="w-full bg-gray-100 text-gray-600 shadow-md rounded-lg p-4">
                <div class="text-gray-500 text-center p-4">
                    <p><span class="text-gray-900 font-bold">Tipo: </span>{{ $mascota['tipo'] }}</p>
                    <p><span class="text-gray-900 font-bold">Raza: </span>{{ $mascota['raza'] }}</p>
                    <p><span class="text-gray-900 font-bold">Edad: </span>{{ $mascota['edad'] }}</p>
                    <p><span class="text-gray-900 font-bold">Sexo: </span>{{ $mascota['sexo'] }}</p>
                    <p class="mt-3"><span class="text-gray-900 font-bold">Dueño: </span>{{ $user->name.' '.$user->apellidos }}</p>
                    <p><span class="text-gray-900 font-bold">DNI: </span>{{ $user->dni }}</p>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <x-jet-danger-button wire:click="resetear">{{ __('Salir') }}</x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    @if($accion=="delete")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Eliminar informe') }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="bg-gray-50 shadow-md rounded-lg p-4">
                <p class="pb-4">¿Deseas eliminar el informe <span class="font-bold">{{ $titulo }}</span>?</p>
                <textarea class="resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" rows="8" readonly>{{ $descripcion }}</textarea>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <x-jet-danger-button wire:click="destroy({{ $informe }})">Eliminar</x-jet-danger-button>
                <x-jet-button wire:click="resetear">{{ __('Salir') }}</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- Tabla de informes --}}
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('mensaje'))
            <div x-data="{ open: true }" class="max-w-xl mx-auto my-4">
                <div x-show="open" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('mensaje') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg @click="open = false" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            </div>
            @elseif(session('eliminar'))
            <div x-data="{ open: true }" class="max-w-xl mx-auto pb-4">
                <div x-show="open" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('eliminar') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg @click="open = false" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Título
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Descripción
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($informes as $informe)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $informe->titulo }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-normal">
                                                <div class="text-sm text-gray-900">{{ $informe->descripcion }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                                <button wire:click="show({{ $informe }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-eye"></i></button>
                                                <button wire:click="edit({{ $informe }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-edit"></i></button>
                                                <button wire:click="fdelete({{ $informe }})" class="text-indigo-600 hover:text-indigo-900  focus:outline-none"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="border-t border-gray-200 p-5">
                                    {{ $informes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
