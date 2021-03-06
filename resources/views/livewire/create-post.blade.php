<div>
    <x-jet-danger-button wire:click="$set('open', true)">
        Crear nuevo post
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear un nuevo post
        </x-slot>

        <x-slot name="content">

            <div wire:loading wire:target="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen Cargando!</strong>
                <span class="block sm:inline">Espere que la imagen carge correctamente.</span>
            </div>

            @if ($image)
                <img class="mb-2" src="{{$image->temporaryUrl()}}"/>
            @endif

            <div class="mb-4">
              <x-jet-label value="Titulo del post"/>
              <x-jet-input type="text" class="w-full" wire:model.defer="title"/>
              <x-jet-input-error for="title" />
            </div>

            <div class="mb-4" >
              <x-jet-label value="Contenido del post"/>
                <div wire:ignore>
                    <textarea id="editor" class="form-control w-full" rows="6" wire:model.defer="content"> </textarea>
                </div>  
              <x-jet-input-error for="content" />
            </div>

            <div>
                <input type="file" wire:model="image" id="{{ $identificador }}"/>
                <x-jet-input-error for="image" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cerrar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">
                Crear
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>    

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then(function(editor){
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });
                livewire.on('resetCKEditor', ()=>{
                    editor.setData('');
                });
            })
            .catch( error => {
                console.error( error );
            } );
    </script>

    @endpush
</div>
