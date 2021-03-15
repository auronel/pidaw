<?php

namespace App\Http\Livewire;

use App\Models\Cita;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Citas extends Component
{
    use WithPagination;

    public $horario = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'];
    public $titulo, $fechaSelec, $fechaHoy, $horaSelec, $horarioCopia, $cita, $cita_id, $user_id, $modal, $disabled = false, $accion = "";

    protected $rules = [
        'titulo' => ['required', 'max:60'],
        'fechaSelec' => ['required',],
        'horaSelec' => ['required'],
    ];

    protected $messages = [
        'titulo.required' => 'Debe elegir una opción.',
        'fechaSelec.required' => 'Debe introducir una fecha.',
        'horaSelec.required' => 'Debe introducir una hora.',
    ];

    public function mount()
    {
        $this->horarioCopia = $this->horario;
        if (session('user_id')) {
            $this->user_id = session('user_id');
        }
    }

    public function render()
    {
        $citas = Cita::orderBy('fecha', 'desc',)->orderBy('hora', 'asc')->paginate(5);

        $citasUsuario = Cita::where('user_id', auth()->user()->id)
            ->where('fecha', '>=', Carbon::now()->format('d-m-Y'))
            ->orderBy('fecha', 'desc',)
            ->orderBy('hora', 'asc')->get();

        return view('livewire.citas', compact('citas', 'citasUsuario'));
    }

    public function store()
    {
        $this->validate();

        $fecha = Carbon::parse($this->fechaSelec)->format('d-m-Y');

        if (auth()->user()->rol == "Administrador" && $this->user_id) {

            Cita::create([
                'titulo' => $this->titulo,
                'fecha' => $fecha,
                'hora' => $this->horaSelec,
                'user_id' => $this->user_id
            ]);

            session()->flash('mensaje', 'Cita almacenada con éxito');
        } elseif (auth()->user()->rol == "Usuario") {
            Cita::create([
                'titulo' => $this->titulo,
                'fecha' => $fecha,
                'hora' => $this->horaSelec,
                'user_id' => auth()->user()->id
            ]);
            session()->flash('mensaje', 'Cita almacenada con éxito');
        } else {
            $this->disabled = true;
            session()->flash('error', 'Debe seleccionar a que usuario se le va a asignar la cita');
        }

        $this->reset([
            'titulo',
            'fechaSelec',
            'horaSelec',
            'disabled'
        ]);
    }

    public function edit(Cita $cita)
    {
        $this->accion = "edit";
        $fecha = Carbon::parse($cita->fecha)->format('Y-m-d');

        $this->titulo = $cita->titulo;
        $this->fechaSelec = $fecha;
        $this->cita_id = $cita->id;

        $this->validarFecha();
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $cita = Cita::find($this->cita_id);
        $fecha = Carbon::parse($this->fechaSelec)->format('d-m-Y');

        $cita->update([
            'titulo' => $this->titulo,
            'fecha' => $fecha,
            'hora' => $this->horaSelec,
        ]);

        session()->flash('mensaje', 'Cita actualizada con éxito');

        $this->reset([
            'titulo',
            'fechaSelec',
            'horaSelec',
            'accion',
        ]);

        $this->horarioCopia = $this->horario;
    }

    public function fdelete($cita)
    {
        $this->cita = Cita::find($cita['id']);

        $this->accion = "delete";
        $this->modal = true;
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();

        $this->reset([
            'modal',
            'cita'
        ]);

        session()->flash('mensaje', 'Cita eliminada con éxito');
    }

    public function validarFecha()
    {
        $this->fechaHoy = Carbon::now()->format('Y-m-d');
        $fechaCitas = [];

        foreach (Cita::all()->where('fecha', Carbon::parse($this->fechaSelec)->format('d-m-Y')) as $key => $value) {
            array_push($fechaCitas, $value);
        }

        if (count($fechaCitas) == 0) {
            $this->horarioCopia = $this->horario;
        } else {
            $this->horarioCopia = $this->horario;
            for ($i = 0; $i < count($fechaCitas); $i++) {
                $x = ($fechaCitas[$i]['hora']);
                for ($j = 0; $j < count($this->horario); $j++) {
                    if ($this->horario[$j] == $x) {
                        unset($this->horarioCopia[$j]);
                    }
                }
            }
        }

        if ($this->fechaSelec < $this->fechaHoy) {
            $this->disabled = true;
        } else {
            $this->disabled = false;
        }
    }

    public function resetear()
    {
        $this->reset([
            'titulo',
            'fechaSelec',
            'horaSelec',
            'accion',
            'disabled',
        ]);

        $this->horarioCopia = $this->horario;

        $this->resetValidation();
    }
}
