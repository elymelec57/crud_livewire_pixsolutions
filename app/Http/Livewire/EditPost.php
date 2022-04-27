<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $post;
    public $open, $image;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    public function render()
    {
        return view('livewire.edit-post');
    }
    
    public function mount(Post $post){
        $this->post = $post;
    }

    public function save(){

        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);

            $this->post->image = $this->image->store('post');
        }

        $this->post->save();
        $this->reset(['open']);
        $this->emitTo('show-post','render');
        $this->emit('alert', 'Post actualizado con exito');
    }
}
