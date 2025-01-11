@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center space-y-6">
    <x-pokemon-card :card="$card" :isLink="false" />

    <!-- Action Buttons -->
    <div class="flex justify-center space-x-4">
        <a href="{{ route('cards.index') }}" 
           class="text-sm text-gray-600 hover:text-gray-800">
            Back to List
        </a>
        @if($card->id != 2)
            <a href="{{ route('cards.edit', $card->id) }}" 
               class="text-sm text-yellow-600 hover:text-yellow-800">
                Edit Card
            </a>
            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="text-sm text-red-600 hover:text-red-800"
                        onclick="return confirm('Are you sure you want to delete this card?')">
                    Delete Card
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
