<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductMain extends Component
{
    public $search, $descripcion, $id;

    #[validate('required')]
    public $nombre, $cantidad, $precio, $disponible;

    public function render()
    {
        $productos = Product::where('nombre', 'like', '%' . $this->search . '%')
            ->latest()->paginate();
        return view('livewire.product-main', compact('productos'));
    }

    public function save()
    {
        $this->validate();
        if (!$this->id) {
            Product::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'cantidad' => $this->cantidad,
                'precio' => $this->precio,
                'disponible' => $this->disponible
            ]);
        } else {
            $producto=Product::find($this->id);
            $producto->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'cantidad' => $this->cantidad,
                'precio' => $this->precio,
                'disponible' => $this->disponible
            ]);
        }
    }

    public function edit(Product $item)
    {
        $this->id = $item->id;

        $this->nombre = $item->nombre;
        $this->descripcion = $item->descripcion;
        $this->cantidad = $item->cantidad;
        $this->precio = $item->precio;
        $this->disponible = $item->disponible;
        $this->modal('showform')->show();
    }

    public function create()
    {
        $this->reset(['id', 'nombre', 'descripcion', 'cantidad', 'precio', 'disponible']);
        $this->modal('showform')->show();
    }
}
