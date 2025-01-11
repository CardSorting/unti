@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 p-4">
        @forelse ($cards as $card)
            <x-pokemon-card :card="$card" class="mx-auto" />
        @empty
            <div class="col-span-full">
                <div class="bg-white/10 p-8 rounded-2xl shadow-xl text-center backdrop-blur-sm border border-white/20">
                    <h3 class="pokemon-name text-xl mb-4">No Pokemon Cards Yet</h3>
                    <p class="text-gray-600 mb-6">Create your first Pokemon card to get started!</p>
                    <a href="{{ route('cards.create') }}" 
                       class="inline-block bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-lg shadow-lg transition-all duration-200">
                        Create New Card
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
