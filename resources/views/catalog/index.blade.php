<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catálogo de Películas') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="grid grid-cols-2">
 
                        @foreach( $films as $key => $pelicula )
                        <div class="border border-gray-500 hover:border-gray-100 m-2 p-2 rounded-xl">
                         
                            <a href="{{ route('catalog.show', $pelicula->id ) }}" class="grid grid-cols-[30%_70%]">
                                <div>
                                    <img src="{{$pelicula['poster']}}" class="max-h-52 rounded-md"/>
                                </div>
                                <div>
                                    <h4 class="m-1 text-3xl">
                                        {{$pelicula['title']}} - {{$pelicula['year']}}
                                    </h4>
                                    <h4 class="m-1 italic">
                                        {{$pelicula['director']}}
                                    </h4>
                                    <h4 class="m-1 overflow-hidden max-h-24 mt-3" max>
                                        {{$pelicula['synopsis']}}
                                    </h4>
                                    @if($pelicula['rented'] == false) 
                                        <span class="border border-gray-500 hover:bg-green-300 bg-green-500 px-4 py-1 rounded-md " >
                                            Disponible
                                        </span>
                                    @else
                                        <span class="border border-gray-500 hover:bg-blue-400 bg-blue-500 px-4 py-1 rounded-md " >
                                            Alquilada
                                        </span>
                                    @endif

                                </div>
                            </a>
                        </div>
                        @endforeach
                     
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

