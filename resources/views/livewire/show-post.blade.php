<div wire:init="loadPosts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- component -->
    
        <!-- component -->
        <div class="table w-full p-2">

            <div class="px-6 py-4 flex item-center">

                <div class="flex item-center">
                    <span>Mostrar</span>
                    <select wire:model="cant" class="mx-2 form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entradas</span>
                </div>

                <x-jet-input type="text" class="flex-1 mx-4" placeholder="Escriba los que busca"
                    wire:model="search" />

                @livewire('create-post')

            </div>

            @if (count($posts))
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" wire:click="order('id')" class="px-6 py-3 cursor-pointer">
                                    ID
                                </th>
                                <th scope="col" wire:click="order('title')" class="px-6 py-3 cursor-pointer">
                                    Title
                                </th>
                                <th scope="col" wire:click="order('content')" class="px-6 py-3 cursor-pointer">
                                    content
                                </th>
                                <th scope="col" colspan="2" class="px-6 py-3 ">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $item)
                                <tr class="odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $item->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $item->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {!! $item->content !!}
                                    </td>
                                    <td class="px-6 py-4  text-right flex">
                                        {{-- <a href="#" wire:click="edit({{$item}})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a> --}}
                                        <a class="btn btn-green" wire:click="edit({{ $item }})">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a class="btn btn-red ml-2" wire:click="$emit('deletePost',{{ $item->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($posts->hasPages())
                        <div class="px-6 py-3">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="px-6 py-4">
                    <p>No hay datos disponibles</p>
                </div>
            @endif
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open_edit">
        <x-slot name="title">
            Editar el Post {{ $post->title }}
        </x-slot>
        <x-slot name="content">

            <div wire:loading wire:target="image"
                class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Imagen Cargando!</strong>
                <span class="block sm:inline">Espere que la imagen carge correctamente.</span>
            </div>

            @if ($image)
                <img class="mb-2" src="{{ $image->temporaryUrl() }}" />
            @else
                <img class="mb-2" src="{{ Storage::url($post->image) }}" />
            @endif


            <div class="mb-4">
                <x-jet-label value="Titulo del post" />
                <x-jet-input type="text" class="w-full" wire:model.defer="post.title" />
                <x-jet-input-error for="post.title" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Contenido del post" />
                <textarea class="form-control w-full" rows="6" wire:model="post.content"> </textarea>
                <x-jet-input-error for="post.content" />
            </div>

            <div>
                <input type="file" wire:model="image" id="{{ $identificador }}" />
                <x-jet-input-error for="image" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open_edit', false)">
                Cerrar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="save, image"
                class="disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
        <script src="sweetalert2.all.min.js"></script>
        <script>
            livewire.on('deletePost', postId => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('show-post', 'delete', postId);

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
