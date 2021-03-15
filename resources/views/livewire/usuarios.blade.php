<div>
    {{-- Formulario para editar usuario --}}
    @if($accion=="editar")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Editar usuario') }}
            </div>
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
                <div class="max-w-xl mx-auto px-2">
                    <x-jet-label for="dni" value="{{ __('DNI') }}" />
                    <x-jet-input wire:model="dni" id="dni" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-xl mx-auto px-2">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-xl mx-auto px-2">
                    <x-jet-label for="apellidos" value="{{ __('Apellidos') }}" />
                    <x-jet-input wire:model="apellidos" id="apellidos" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-xl mx-auto px-2">
                    <x-jet-label for="telefono" value="{{ __('Teléfono') }}" />
                    <x-jet-input wire:model="telefono" id="telefono" class="block mt-1 w-full" type="text" required />
                </div>

                <div class="mt-4 max-w-xl mx-auto px-2">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input wire:model="email" id="email" class="block mt-1 w-full" type="email" required />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="mt-2 text-center">
                <div class="mt-4 max-w-xl mx-auto">
                    <x-jet-button wire:click="update">{{ __('Actualizar') }}</x-jet-button>
                    <x-jet-danger-button wire:click="resetear">{{ __('Cancelar') }}</x-jet-danger-button>
                </div>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- Tarjeta de usuario --}}
    @if($accion=="info")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold xs:text-sm">
                {{ __('Mascotas del usuario ') }}
                <p class="text-gray-600 font-normal">{{ $name.' '.$apellidos }}</p>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="bg-gray-50 overflow-hidden shadow-md sm:rounded-lg py-4">
                {{-- Datos de las mascotas --}}
                @if($mascotas->count())
                @foreach($mascotas as $mascota)
                <div class="w-full text-center py-3">
                    <h2 class="font-bold pb-2 text-indigo-500 uppercase">{{ $mascota->nombre }}</h2>
                    <ul>
                        <li class="font-bold">Tipo: <span class="text-gray-600 font-normal">{{ $mascota->tipo }}</span></li>
                        <li class="font-bold">Raza: <span class="text-gray-600 font-normal">{{ $mascota->raza }}</span></li>
                        <li class="font-bold">Edad: <span class="text-gray-600 font-normal">{{ $mascota->edad }}</span></li>
                        <li class="font-bold">Sexo: <span class="text-gray-600 font-normal">{{ $mascota->sexo }}</span></li>
                    </ul>
                </div>
                @endforeach
                @else
                <div class="text-gray-500 text-center p-4">
                    <p>El usuario no tiene mascotas actualmente</p>
                </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <div class="flex flex-col space-y-1 justify-center items-center w-full">
                    <div class="mt-4 flex space-x-2">
                        <x-jet-button wire:click="mascotaUsuario">{{ __('Añadir mascota') }}</x-jet-button>
                        <x-jet-button wire:click="citaUsuario">{{ __('Añadir cita') }}</x-jet-button>
                        <x-jet-danger-button wire:click="resetear">{{ __('Salir') }}</x-jet-danger-button>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    @if($accion=="delete")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Eliminar usuario') }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="bg-gray-50 shadow-md rounded-lg text-center p-4">
                <p>¿Deseas eliminar al usuario <span class="font-bold">{{ $name.' '.$apellidos }}</span>?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                <x-jet-danger-button wire:click="destroy({{ $user }})">Eliminar</x-jet-danger-button>
                <x-jet-button wire:click="resetear">{{ __('Salir') }}</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2 ml-2">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-indigo-500">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <x-jet-input wire:model.debounce.500ms="search" type="search" class="pl-10 ml-2" autocomplete="off"></x-jet-input>
            </div>
            @if(session('actualizar'))
            <div x-data="{ open: true }" class="max-w-xl mx-auto mt-4">
                <div x-show="open" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('actualizar') }}</span>
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
                                @if($usuarios->count())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                DNI
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Apellidos
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Teléfono
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                E-mail
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($usuarios as $usuario)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($usuario->profile_photo_path)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="/storage/{{ $usuario->profile_photo_path }}" alt="{{ $usuario->name }}" />
                                                        @else
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $usuario->dni }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $usuario->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $usuario->apellidos }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $usuario->telefono }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $usuario->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                                <button wire:click="show({{ $usuario }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-eye"></i></button>
                                                <button wire:click="edit({{ $usuario }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="fas fa-user-edit"></i></button>
                                                <button wire:click="fdelete({{ $usuario }})" class="text-indigo-600 hover:text-indigo-900  focus:outline-none"><i class="fas fa-user-times"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="border-t border-gray-200 p-5">
                                    {{ $usuarios->links() }}
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
