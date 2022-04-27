<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = false;
    public $title , $content, $image;
    public $identificador;
 
    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048'
    ];

    public function mount(){
        $this->identificador = rand();
    }

    /*
    // este codigo es para ejecutar las validaciones en tiempo real
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    */

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){

        $this->validate();
        $image = $this->image->store('public/post');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);

        $this->reset(['open','title','content','image']);
        $this->identificador = rand();
        $this->emitTo('show-post','render');
        $this->emit('alert', 'Post registrado con exito');
    }

    public function updatingOpen(){
        if ($this->open == false) {
            $this->reset(['title','content','image']);
            $this->identificador = rand();
            $this->emit('resetCKEditor');
        }
    }

}
