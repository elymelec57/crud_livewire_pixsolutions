<?php

namespace App\Http\Livewire;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Livewire\Component;

class ShowPost extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $post, $image;
    public $search = '';
    public $open_edit = false;
    public $sort = 'id';
    public $direction = 'desc';
    protected $listeners = ['render' => 'render', 'delete' => 'delete'];
    public $cant = '10';
    public $readyToLoad = false;
    public $identificador;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    public function mount(){
        $this->post = new Post();
        $this->identificador = rand();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];

    public function loadPosts(){
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad) {
            
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)->paginate($this->cant);

        }else{
            $posts = [];
        }

        return view('livewire.show-post', compact('posts'));
    }

    public function order($sort){
        $this->sort = $sort;
    }
    
    public function edit(Post $post){
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update(){
        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);

            $this->post->image = $this->image->store('public/post');
        }

        $this->post->save();
        $this->reset(['open_edit', 'image']);
        $this->identificador = rand();
        $this->emit('alert', 'Post actualizado con exito');
    }

    public function delete(Post $post){
        $post->delete();
    }
}
