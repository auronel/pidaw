<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $nombre, $descripcion, $precio, $foto, $imagen, $categoria, $precioSearch, $categoriaSearch, $producto, $producto_id, $modal, $accion = "";
    public $categorias = ['Pienso', 'Golosinas y premios', 'Higiene', 'Antiparasitarios', 'Accesorios', 'Juguetes'];
    protected $min = 1, $max = 3000;

    protected $messages = [
        'nombre.regex' => 'El :attribute debe contener solo letras.',
        'descripcion.required' => 'Debe introducir una descripcion.',
        'precio.regex' => 'La :attribute debe contener solo 4 cifras y 2 decimales como máximo.',
        'foto.image' => 'El campo :attribute debe ser de tipo imágen.',
        'foto.mimes' => 'La :attribute no tiene el formato correcto.',
    ];

    public function render()
    {
        switch ($this->precioSearch) {
            case 1:
                $this->min = 1;
                $this->max = 3000;
                break;
            case 2:
                $this->min = 1;
                $this->max = 25;
                break;
            case 3:
                $this->min = 25;
                $this->max = 50;
                break;
            case 4:
                $this->min = 50;
                $this->max = 100;
                break;
        }

        return view(
            'livewire.productos',
            [
                'productos' => Producto::where('categoria', 'like', "%$this->categoriaSearch%")
                    ->whereBetween('precio', [$this->min, $this->max])
                    ->orderBy('id', 'desc')
                    ->paginate(8)
            ]
        );
    }

    public function create()
    {
        $this->reset([
            'nombre',
            'descripcion',
            'precio',
            'categoria',
            'foto',
        ]);

        $this->accion = "create";
        $this->modal = true;
    }

    public function store()
    {
        $this->validate([
            'nombre' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'regex:/^[0-9]{1,4}\.?([0-9]{1,2})?$/', 'max:80'],
            'categoria' => ['required', 'string'],
            'foto' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg'],
        ]);

        Producto::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'categoria' => $this->categoria,
            'foto' => $this->foto->getClientOriginalName(),
        ]);

        $this->foto->storeAs("public/productos", $this->foto->getClientOriginalName());

        $this->reset([
            'accion',
            'producto',
        ]);

        session()->flash('mensaje', 'Producto almacenado con éxito');
    }

    public function edit(Producto $producto)
    {
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->precio = $producto->precio;
        $this->categoria = $producto->categoria;
        $this->foto = $producto->foto;
        $this->producto_id = $producto->id;

        $this->imagen = $this->foto;
        $this->accion = "edit";
        $this->modal = true;

        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'nombre' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'regex:/^[0-9]{1,4}\.?([0-9]{1,2})?$/', 'max:80'],
            'categoria' => ['required', 'string'],
        ]);

        $producto = Producto::find($this->producto_id);

        $actual = $producto->foto;
        $nueva = $this->foto;

        if ($nueva != $actual) {

            $this->validateOnly($this->foto, [
                'foto' => 'image',
                'foto' => 'mimes:jpg,png,jpeg,gif,svg'
            ]);

            $producto->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'categoria' => $this->categoria,
                'foto' => $nueva->getClientOriginalName(),
            ]);

            $imagen = $this->foto->getClientOriginalName();

            Storage::disk('public')->delete('productos/' . $actual);
            $this->foto->storeAs("public/productos", $imagen);
        } else {

            $producto->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'categoria' => $this->categoria,
                'foto' => $producto->foto,
            ]);
        }

        $this->reset([
            'modal'
        ]);

        session()->flash('mensaje', 'Producto actualizado con éxito');
    }

    public function fdelete($producto)
    {
        $this->producto = Producto::find($producto['id']);

        $this->nombre = $producto['nombre'];
        $this->foto = $producto['foto'];

        $this->accion = "delete";
        $this->modal = true;
    }

    public function destroy(Producto $producto)
    {
        Storage::disk('public')->delete('productos/' . $this->foto);
        $producto->delete();

        $this->reset([
            'producto',
            'modal'
        ]);

        session()->flash('eliminar', 'Producto eliminado con éxito');
    }

    public function resetear()
    {
        $this->reset([
            'accion',
            'producto'
        ]);

        $this->resetValidation();
    }

    public function updatingcategoriaSearch()
    {
        $this->resetPage();
    }

    public function updatingprecioSearch()
    {
        $this->resetPage();
    }
}
