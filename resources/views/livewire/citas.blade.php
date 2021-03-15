<div class="pt-6">
    @if($accion=="delete")
    <x-jet-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center font-bold">
                {{ __('Eliminar cita') }}
            </div>

        </x-slot>
        <x-slot name="content">
            <div class="bg-gray-50 shadow-md rounded-lg text-center p-4">
                @if(auth()->user()->rol == "Administrador")
                <p>¿Desea eliminar la cita?</p>
                @else
                <p>¿Desea cancelar la cita?</p>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-center">
                @if(auth()->user()->rol == "Administrador")
                <x-jet-danger-button wire:click="destroy({{ $cita }})">Eliminar</x-jet-danger-button>
                @else
                <x-jet-danger-button wire:click="destroy({{ $cita }})">Cancelar</x-jet-danger-button>
                @endif
                <x-jet-button wire:click="resetear">{{ __('Salir') }}</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="text-center">
                @if ($errors->any())
                <div class="max-w-7xl py-6">
                    <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="max-w-lg mx-auto">
                <x-jet-label for="titulo" value="{{ __('Motivo') }}" />
                <select wire:model="titulo" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                    <option value="null" disabled>Elige una opción</option>
                    <option value="Consulta">Consulta</option>
                    <option value="Desparasitación">Desparasitación</option>
                    <option value="Vacunación">Vacunación</option>
                    @if(auth()->user()->rol=="Administrador")
                    <option value="Quirófano">Quirófano</option>
                    @endif
                </select>
            </div>

            <div class="max-w-lg mx-auto mt-4">
                <x-jet-label for="fechaSelec" value="{{ __('Fecha') }}" />
                <div x-data="{disabled: @entangle('disabled')}">
                    <input wire:model="fechaSelec" wire:change.debounce.500ms="validarFecha" type="date" id="fechaSelec" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block" :readonly="disabled" />
                </div>
                @if($disabled && $accion=="")
                <p class="text-xs text-red-500 my-3 font-bold">La cita debe ser como mínimo para el día actual.</p>
                @elseif($disabled && $accion=="edit")
                <p class="text-xs text-red-500 my-3 font-bold">No se puede modificar una cita que ya ha expirado.</p>
                @endif
            </div>

            <div class="max-w-lg mx-auto mt-4">
                <x-jet-label for="hora" value="{{ __('Hora') }}" />
                <select wire:model="horaSelec" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                    <option value="null" disabled>Elige una opción</option>
                    @foreach($horarioCopia as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="max-w-lg mx-auto mt-4">
                @if($accion=="" && auth()->user()->rol=="Usuario")
                <x-jet-button wire:click="store" :disabled="$disabled">Pedir cita</x-jet-button>
                @elseif($accion=="edit" && auth()->user()->rol=="Usuario")
                <x-jet-button wire:click="update" :disabled="$disabled">Actualizar cita</x-jet-button>
                @elseif($accion=="" && auth()->user()->rol=="Administrador")
                <x-jet-button wire:click="store" :disabled="$disabled">Añadir cita</x-jet-button>
                @elseif($accion=="edit" && auth()->user()->rol=="Administrador")
                <x-jet-button wire:click="update" :disabled="$disabled">Actualizar cita</x-jet-button>
                @elseif($accion=="delete" && auth()->user()->rol=="Administrador")
                <x-jet-button wire:click="store">Añadir cita</x-jet-button>
                @elseif($accion=="delete" && auth()->user()->rol=="Usuario")
                <x-jet-button wire:click="store">Pedir cita</x-jet-button>
                @endif
                <x-jet-danger-button wire:click="resetear">Resetear datos</x-jet-danger-button>
            </div>


            @if(session('error'))
            <div x-data="{ open: true }" class="max-w-xl mx-auto mt-4">
                <div x-show="open" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg @click="open = false" class="fill-current h-6 w-6 text-red-500" role="button" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            </div>
            @elseif(session('mensaje'))
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
            @endif


        </div>
        @if(auth()->user()->rol=="Administrador")
        @if($citas->count())
        <div class="flex flex-col shadow-xl sm:rounded-lg mt-4">
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
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hora
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        DNI del usuario
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre del usuario
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($citas as $cita)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->titulo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->fecha }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->hora }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->user->dni }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->user->name.' '.$cita->user->apellidos }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                        <button wire:click="edit({{ $cita }})" class="text-indigo-600 hover:text-indigo-900 mr-4 focus:outline-none"><i class="far fa-edit"></i></button>
                                        <button wire:click="fdelete({{ $cita }})" class="text-indigo-600 hover:text-indigo-900  focus:outline-none"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="border-t border-gray-200 p-5">
                            {{ $citas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @else
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 bg-white shadow-xl sm:rounded-lg">
            @if($citasUsuario->count())
            <div class="max-w-sm mx-auto">
                <h2 class="pt-4 pb-2 text-xl text-center">Citas del usuario {{ auth()->user()->name }}</h2>
            </div>
            @foreach($citasUsuario as $cita)
            <div class="max-w-sm mx-auto py-4 border-t border-gray-400 text-center">
                <div>
                    <ul>
                        <li class="text-indigo-500 font-bold">{{ $cita->titulo }}</li>
                        <li>{{ $cita->fecha }}</li>
                        <li>{{ $cita->hora }}</li>
                    </ul>
                </div>
                <div class="pt-4">
                    <x-jet-button wire:click="edit({{ $cita }})">Modificar cita</x-jet-button>
                    <x-jet-danger-button wire:click="fdelete({{ $cita }})">Cancelar cita</x-jet-danger-button>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @endif
    </div>
    <script>
        let fecha = document.querySelector("#fechaSelec")

        fecha.addEventListener('click', () => {
            fecha.min = new Date().toISOString().split("T")[0]
        })

    </script>
</div>
