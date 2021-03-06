<div>
    <a wire:click="$set('open', true)" class="bg-red-500 p-2 text-white hover:shadow-lg text-xs font-thin cursor-pointer rounded">
        Editar
    </a>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar el Post {{$post->title}}
        </x-slot>
        <x-slot name="content">

            <div wire:loading wire:target="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen Cargando!</strong>
                <span class="block sm:inline">Espere que la imagen carge correctamente.</span>
            </div>

            @if ($image)
            <img class="mb-2" src="{{$image->temporaryUrl()}}"/>
            @else
                <img class="mb-2" src="{{Storage::url($post->image)}}" />
            @endif


            <div class="mb-4">
                <x-jet-label value="Titulo del post"/>
                <x-jet-input type="text" class="w-full" wire:model.defer="post.title"/>
                <x-jet-input-error for="post.title" />
              </div>
  
              <div class="mb-4">
                <x-jet-label value="Contenido del post"/>
                <textarea class="form-control w-full" rows="6" wire:model="post.content"> </textarea>
                <x-jet-input-error for="post.content" />
              </div>

              <div>
                <input type="file" wire:model="image" />
                <x-jet-input-error for="image" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cerrar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
