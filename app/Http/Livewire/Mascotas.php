<?php

namespace App\Http\Livewire;

use App\Models\Mascota;
use Livewire\Component;
use Livewire\WithPagination;

class Mascotas extends Component
{
    use WithPagination;

    public $nombre, $tipo, $raza, $edad, $sexo, $usuario, $user_id, $mascota, $mascota_id, $informes, $modal, $accion = "", $search = "";

    protected $rules = [
        'nombre' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
        'tipo' => ['required', 'string'],
        'raza' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:80'],
        'edad' => ['required', 'regex:/^[0-9]{1,2}$/'],
        'sexo' => ['required', 'string'],
    ];

    protected $messages = [
        'nombre.regex' => 'El :attribute debe contener solo letras.',
        'tipo.required' => 'Debe seleccionar un tipo.',
        'raza.regex' => 'La :attribute debe contener solo letras.',
        'edad.regex' => 'La :attribute debe contener solo números y máximo 2 caracteres.',
    ];

    public function mount()
    {
        if (session('user_id')) {
            $this->user_id = session('user_id');
            $this->accion = "create";
            $this->modal = true;
        }
    }

    public function render()
    {
        return view('livewire.mascotas', [
            'mascotas' => Mascota::where('nombre', 'like', "%$this->search%")->orderBy('id', 'desc')->paginate(5)
        ]);
    }

    public function show(Mascota $mascota)
    {
        $this->accion = "info";
        $this->modal = true;

        $this->nombre = $mascota->nombre;
        $this->tipo = $mascota->tipo;
        $this->raza = $mascota->raza;
        $this->edad = $mascota->edad;
        $this->sexo = $mascota->sexo;
        $this->mascota_id = $mascota->id;

        $this->informes = $mascota->informes;
        $this->usuario = $mascota->user;
    }

    public function store()
    {
        $this->validate();

        Mascota::create([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'raza' => $this->raza,
            'edad' => $this->edad,
            'sexo' => $this->sexo,
            'user_id' => $this->user_id
        ]);

        $this->reset([
            'accion'
        ]);

        session()->flash('mensaje', 'Mascota almacenada con éxito');
    }

    public function edit(Mascota $mascota)
    {
        $this->accion = "edit";
        $this->modal = true;

        $this->nombre = $mascota->nombre;
        $this->tipo = $mascota->tipo;
        $this->raza = $mascota->raza;
        $this->edad = $mascota->edad;
        $this->sexo = $mascota->sexo;
        $this->mascota_id = $mascota->id;

        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $mascota = Mascota::find($this->mascota_id);

        $mascota->update([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'raza' => $this->raza,
            'edad' => $this->edad,
            'sexo' => $this->sexo,
        ]);

        $this->reset([
            'modal'
        ]);

        session()->flash('mensaje', 'Mascota actualizada con éxito');
    }

    public function fdelete($mascota)
    {
        $this->mascota = Mascota::find($mascota['id']);

        $this->nombre = $mascota['nombre'];

        $this->usuario = $this->mascota->user;

        $this->accion = "delete";
        $this->modal = true;
    }

    public function destroy(Mascota $mascota)
    {
        $mascota->delete();

        $this->reset([
            'mascota',
            'modal'
        ]);

        session()->flash('eliminar', 'Mascota eliminada con éxito');
    }

    public function resetear()
    {
        $this->reset([
            'accion',
        ]);

        $this->resetValidation();
    }

    public function nuevoInforme()
    {
        session()->flash('mascota_id', $this->mascota_id);
        return redirect('informes');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingModal()
    {
        $this->reset([
            'accion',
        ]);
    }
}
