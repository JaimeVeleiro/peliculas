<x-app-layout>

    <x-slot name="header">
       <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
           {{ __('AÑADIR PELÍCULA') }}
       </h2>
   </x-slot>

   <div class="py-2" >
    <div class="max-w-7xl mx-auto sm:px-6 lg:p-8">
       <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-50">
        
            <form action="{{ route('catalog.store')}}" method="POST" class="max-h-[80vh] p-10 items-center justify-center align-middle grid grid-cols-[30%_70%] grid-rows-6 justify-items-center">
            @csrf
            
                <label for="title" class="dark:text-gray-200 text-4xl ">Título</label>
                <input placeholder="Título de la Película" class="rounded-lg h-16 w-96" type="text" name="title" id="title">

                <label for="year" class="dark:text-gray-200 text-4xl ">Año</label>
                <input  placeholder="Año de Publicación" class="rounded-lg h-16 w-96" type="number" name="year" id="year">
        
                <label for="director" class="dark:text-gray-200 text-4xl">Director</label>
                <input placeholder="Director" class="rounded-lg h-16 w-96" type="text" name="director" id="director">
        
                <label for="poster" class="dark:text-gray-200 text-4xl">Poster</label>
                <input class="rounded-lg h-16 w-96" type="text" placeholder="URL de la API" name="poster" id="poster">
        
                <label for="synopsis" class="dark:text-gray-200 text-4xl">Sinopsis</label>
                <textarea placeholder="Escribe un pequeño resumen" class="rounded-lg h-24 w-96" name="synopsis" id="synopsis" class="form-control" rows="3"></textarea>
                
                
               <div class="col-span-2 text-center w-96">
                  <button type="submit" class=" bg-green-400 btn btn-primary m-10 p-2 mt-6 border rounded-lg w-72 h-16">
                     Añadir Película
                  </button>
               </div>
               
            </form>
          </div>
       </div>
    </div>
 </div>

</x-app-layout>