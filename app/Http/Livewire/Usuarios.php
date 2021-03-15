<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithPagination;

    public $dni, $name, $apellidos, $telefono, $email, $foto, $user, $user_id, $mascotas = [], $modal, $accion = "", $search = "";

    public function render()
    {
        return view(
            'livewire.usuarios',
            [
                'usuarios' => User::where('name', 'like', "%$this->search%")
                    ->orWhere('apellidos', 'like', "%$this->search%")
                    ->orWhere('dni', 'like', "%$this->search%")
                    ->orderBy('id', 'desc')
                    ->paginate(5)
            ]
        );
    }

    public function show(User $user)
    {
        $this->accion = "info";
        $this->modal = true;

        $this->dni = $user->dni;
        $this->name = $user->name;
        $this->apellidos = $user->apellidos;
        $this->user_id = $user->id;

        $this->mascotas = $user->mascotas;
    }

    public function edit(User $user)
    {
        $this->accion = "editar";
        $this->modal = true;

        $this->dni = $user->dni;
        $this->name = $user->name;
        $this->apellidos = $user->apellidos;
        $this->telefono = $user->telefono;
        $this->email = $user->email;
        $this->user_id = $user->id;

        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'dni' => ['required', 'regex:/^[1-9]{8}[A-Z]$/', Rule::unique('users')->ignore($this->user_id)],
            'name' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'apellidos' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'telefono' => ['required', 'regex:/^[0-9]{9}$/', Rule::unique('users')->ignore($this->user_id)],
            'email' => ['required', 'email:filter,dns', 'max:255', Rule::unique('users')->ignore($this->user_id)],
        ]);

        $user = User::find($this->user_id);

        $user->update([
            'dni' => $this->dni,
            'name' => $this->name,
            'apellidos' => $this->apellidos,
            'telefono' => $this->telefono,
            'email' => $this->email,
        ]);

        $this->reset([
            'modal'
        ]);

        session()->flash('actualizar', 'Usuario actualizado con éxito');
    }

    public function fdelete($user)
    {
        $this->user = User::find($user['id']);

        $this->name = $user['name'];
        $this->apellidos = $user['apellidos'];

        $this->accion = "delete";
        $this->modal = true;
    }

    public function destroy(User $user)
    {
        $user->deleteProfilePhoto();
        $user->delete();

        $this->reset([
            'user',
            'modal',
            'search'
        ]);

        session()->flash('eliminar', 'Usuario eliminado con éxito');
    }

    public function resetear()
    {
        $this->reset([
            'accion'
        ]);

        $this->resetValidation();
    }

    public function mascotaUsuario()
    {
        session()->flash('user_id', $this->user_id);
        return redirect('mascotas');
    }

    public function citaUsuario()
    {
        session()->flash('user_id', $this->user_id);
        return redirect('citas');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
