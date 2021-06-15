<div>
    <x-slot name="course">
        {{$course->slug}}
    </x-slot>

    <h1 class="text-2xl font-bold">LECCIONES DEL CURSO</h1>
    <hr class="mt-2 mb-6">

   

    @foreach ($course->sections as $item)
    	<article class="card mb-6">
    		<div class="card-body bg-gray-100">
    			@if ($section->id == $item->id)
    			<form wire:submit.prevent="update">
    				<input wire:model="section.name" type="text" class="form-input w-full" placeholder="Ingrese nombre de la sección">
    				@error('section.name')
    				<span class="text-xs text-red-500">{{$message}}</span>
    				@enderror
    			</form>
    			@else
    			<header class="flex justify-between items-center">
    				<h1 class="cursor-pointer"><strong>Sección: </strong> {{$item->name}}</h1>
    				<div >
    					<i class="fas fa-edit text-blue-500 cursor-pointer" wire:click="edit({{$item}})"></i>
    					<i class="fas fa-eraser text-red-500 cursor-pointer" wire:click="destroy({{$item}})"></i>
    				</div>
    			</header>
    			<div>

    				@livewire('instructor.course-lesson', ['section' => $item], key($item->id))
    			</div>
    			@endif
    		</div>
    	</article>
    @endforeach

    <div x-data="{open: false}">
    	<a x-show="!open" x-on:click="open = true" class="flex item-center cursor-pointer">
    		<i class="far fa-plus-square text-2xl text-red-500 mr-2"></i>
    		Agregar nueva sección
    	</a>
    	<article class="card" x-show="open">
    		<div class="card-body bg-gray-100">
    			<h1 class="text-xl font-bold mb-4">Agregar nueva sección</h1>

    			<div>
    				<input wire:model="name" type="text" class="form-input w-full" placeholder="Nombre de la sección">
    				@error('name')
    				<span class="text-xs text-red-500">{{$message}}</span>
    				@enderror
    			</div>
    			<div class="flex justify-end mt-2">
    				<button class="btn btn-danger" x-on:click="open = false">Cancelar</button>
    				<button class="btn btn-primary ml-2" wire:click="store">Agregar</button>
    			</div>
    		</div>
    	</article>
    </div>
</div>
