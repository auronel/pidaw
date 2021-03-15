<?php

namespace App\Http\Livewire;

use App\Models\Informe;
use Livewire\Component;
use Livewire\WithPagination;

class Informes extends Component
{
    use WithPagination;

    public $titulo, $descripcion, $mascota_id, $mascota, $user, $informe, $informe_id, $modal, $accion = "";

    protected $rules = [
        'titulo' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:100'],
        'descripcion' => ['required', 'string'],
    ];

    public function mount()
    {
        if (session('mascota_id')) {
            $this->mascota_id = session('mascota_id');
            $this->accion = "create";
            $this->modal = true;
        }
    }

    public function render()
    {
        $informes = Informe::orderBy('id', 'desc')->paginate(5);
        return view('livewire.informes', compact('informes'));
    }

    public function show(Informe $informe)
    {
        $this->accion = "info";
        $this->modal = true;

        $this->titulo = $informe->titulo;
        $this->descripcion = $informe->descripcion;

        $this->mascota = $informe->mascota;
        $this->user = $this->mascota->user;
    }

    public function store()
    {
        $this->validate();

        Informe::create([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'mascota_id' => $this->mascota_id,
        ]);

        $this->modal = false;

        session()->flash('mensaje', 'Informe almacenado con éxito');
    }

    public function edit(Informe $informe)
    {
        $this->accion = "edit";
        $this->modal = true;

        $this->titulo = $informe->titulo;
        $this->descripcion = $informe->descripcion;
        $this->informe_id = $informe->id;

        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $informe = Informe::find($this->informe_id);

        $informe->update([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
        ]);

        $this->reset([
            'modal'
        ]);

        session()->flash('mensaje', 'Informe actualizado con éxito');
    }

    public function resetear()
    {
        $this->reset([
            'modal'
        ]);
    }

    public function fdelete($informe)
    {
        $this->informe = Informe::find($informe['id']);

        $this->titulo = $informe['titulo'];

        $this->accion = "delete";
        $this->modal = true;
    }

    public function destroy(Informe $informe)
    {
        $informe->delete();

        $this->reset([
            'informe',
            'modal'
        ]);

        session()->flash('eliminar', 'Informe eliminado con éxito');
    }
}
