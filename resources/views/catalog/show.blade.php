<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SHOW') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class=" m-2 p-2 rounded-xl grid grid-cols-[30%_70%]">
                         
                        <div>
                            <img src="{{$film['poster']}}" class="rounded-md"/>
                        </div>
                        <div class="p-6">
                            <h4 class="m-1 text-6xl">
                                {{$film['title']}}
                            </h4>
                            <h4 class="text-2xl m-1 italic">
                                {{$film['director']}} - {{$film['year']}}
                            </h4>
                            <h4 class="m-1 overflow-hidden max-h-52 ml-3 mb-5 mt-3" max>
                                {{$film['synopsis']}}
                            </h4>
                            <div class="flex space-x-4 mt-4">
                                @if($film['rented'] == false)
                                    <form action="{{ route('catalog.rent', $film['id'])}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="border border-gray-500 hover:bg-green-300 bg-green-500 px-4 py-1 rounded-md">
                                            ✅Disponible
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('catalog.return', $film['id'])}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="border border-gray-500 hover:bg-blue-400 bg-blue-500 px-4 py-1 rounded-md">
                                            🔒Alquilada
                                        </button>
                                    </form>
                                @endif
                            
                                <form action="{{ route('catalog.edit', $film['id']) }}" method="GET">
                                    <button type="submit" class="border border-gray-500 hover:bg-yellow-400 bg-yellow-500 px-4 py-1 rounded-md">
                                        ✏️Editar Película
                                    </button>
                                </form>
                            
                                <form action="{{ route('catalog.index') }}" method="GET">
                                    <button type="submit" class="border border-gray-500 hover:bg-gray-400 bg-gray-500 px-4 py-1 rounded-md">
                                        🔙 Volver al Listado
                                    </button>
                                </form>

                                <form action="{{ route('catalog.delete', $film['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border border-gray-500 hover:bg-red-500 bg-red-700 px-4 py-1 rounded-md">
                                        ⚠️Eliminar Película
                                    </button>
                                </form>
                            </div>
                            
                            


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>