@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center space-y-6">
    <div class="pokemon-card w-[252px] h-[352px] relative rounded-[0.75rem] overflow-hidden"
         style="background: 
            repeating-linear-gradient(
                -45deg,
                transparent,
                transparent 8px,
                rgba(255, 255, 255, 0.05) 8px,
                rgba(255, 255, 255, 0.05) 16px
            ),
            radial-gradient(circle at center, 
                @if($card->type == 'Electric') #F3D677, #D4B85C
                @elseif($card->type == 'Fighting') #D56723, #B85518
                @elseif($card->type == 'Water') #6890F0, #4F6DB3
                @elseif($card->type == 'Fire') #F08030, #CC6A28
                @else #A8A878, #8A8A5C
                @endif);">
        <div class="card-frame absolute inset-0 border-[4px] rounded-[0.75rem]"
             style="border-color: {{ 
                $card->type == 'Electric' ? '#F3D67799' :
                ($card->type == 'Fighting' ? '#D5672399' :
                ($card->type == 'Water' ? '#6890F099' :
                ($card->type == 'Fire' ? '#F0803099' : '#A8A87899'))) }}">
        </div>
        <div class="relative p-3 h-full flex flex-col bg-white/5">
            <!-- Card Header -->
            <div class="flex justify-between items-center mb-1">
                <div class="flex items-center gap-1">
                    <span class="card-title text-[0.65rem]">Basic</span>
                    <span class="card-title text-[0.65rem]">Pokémon</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="card-title text-base text-red-600">{{ $card->hp }} HP</span>
                    <div class="type-icon w-5 h-5 flex items-center justify-center rounded-full
                        @if($card->type == 'Electric') bg-gradient-to-br from-yellow-300 to-yellow-500
                        @elseif($card->type == 'Fighting') bg-gradient-to-br from-orange-600 to-orange-800
                        @elseif($card->type == 'Water') bg-gradient-to-br from-blue-400 to-blue-600
                        @elseif($card->type == 'Fire') bg-gradient-to-br from-orange-400 to-orange-600
                        @else bg-gradient-to-br from-gray-400 to-gray-600
                        @endif">
                    </div>
                </div>
            </div>

            <!-- Pokemon Name -->
            <h2 class="pokemon-name text-base font-bold mb-1 tracking-wide">{{ $card->name }}</h2>

            <!-- Image Frame -->
            <div class="relative mb-2">
                <div class="absolute inset-0 border-[6px] border-[#8b7355] rounded-sm z-10 shadow-inner"></div>
                <div class="image-frame h-32 rounded-sm overflow-hidden relative">
                    @if($card->image_url)
                        <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-gray-400">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pokemon Info -->
            <div class="text-[0.5rem] mb-1 font-medium">
                <span class="italic">{{ $card->category }} Pokémon. </span>
                Length: {{ $card->length }}, Weight: {{ $card->weight }}
            </div>

            <!-- Attacks -->
            <div class="space-y-1 flex-grow">
                @foreach($card->attacks as $attack)
                    <div class="flex items-start gap-1 border-t border-black/10 py-1">
                        <div class="flex gap-0.5 mt-0.5">
                            @for($i = 0; $i < $attack['energyCount']; $i++)
                                <div class="energy-symbol w-4 h-4 rounded-full flex items-center justify-center
                                    @if($card->type == 'Electric') bg-gradient-to-br from-yellow-300 to-yellow-500
                                    @elseif($card->type == 'Fighting') bg-gradient-to-br from-orange-600 to-orange-800
                                    @elseif($card->type == 'Water') bg-gradient-to-br from-blue-400 to-blue-600
                                    @elseif($card->type == 'Fire') bg-gradient-to-br from-orange-400 to-orange-600
                                    @else bg-gradient-to-br from-gray-400 to-gray-600
                                    @endif">
                                </div>
                            @endfor
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-center">
                                <span class="attack-name text-[0.7rem]">{{ $attack['name'] }}</span>
                                <span class="damage-text text-[0.7rem]">{{ $attack['damage'] }}</span>
                            </div>
                            <p class="text-[0.6rem] leading-tight mt-0.5">{{ $attack['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 text-[0.5rem] border-t border-black/10 pt-1 mt-auto">
                <div>
                    <span class="text-gray-600 block">weakness</span>
                    @if($card->weakness)
                        <div class="type-icon mt-1 inline-flex items-center justify-center w-4 h-4 rounded-full
                            @if($card->weakness == 'Electric') bg-gradient-to-br from-yellow-300 to-yellow-500
                            @elseif($card->weakness == 'Fighting') bg-gradient-to-br from-orange-600 to-orange-800
                            @elseif($card->weakness == 'Water') bg-gradient-to-br from-blue-400 to-blue-600
                            @elseif($card->weakness == 'Fire') bg-gradient-to-br from-orange-400 to-orange-600
                            @else bg-gradient-to-br from-gray-400 to-gray-600
                            @endif">
                        </div>
                    @else
                        <div class="mt-1 text-gray-400">None</div>
                    @endif
                </div>
                <div>
                    <span class="text-gray-600 block">resistance</span>
                    @if($card->resistance)
                        <div class="type-icon mt-1 inline-flex items-center justify-center w-4 h-4 rounded-full
                            @if($card->resistance == 'Electric') bg-gradient-to-br from-yellow-300 to-yellow-500
                            @elseif($card->resistance == 'Fighting') bg-gradient-to-br from-orange-600 to-orange-800
                            @elseif($card->resistance == 'Water') bg-gradient-to-br from-blue-400 to-blue-600
                            @elseif($card->resistance == 'Fire') bg-gradient-to-br from-orange-400 to-orange-600
                            @else bg-gradient-to-br from-gray-400 to-gray-600
                            @endif">
                        </div>
                    @else
                        <div class="mt-1 text-gray-400">None</div>
                    @endif
                </div>
                <div>
                    <span class="text-gray-600 block">retreat cost</span>
                    @if($card->retreat_cost)
                        <div class="mt-1 flex justify-center gap-0.5">
                            @for($i = 0; $i < $card->retreat_cost; $i++)
                                <div class="energy-symbol w-3 h-3 rounded-full bg-gradient-to-br from-gray-400 to-gray-600"></div>
                            @endfor
                        </div>
                    @else
                        <div class="mt-1 text-gray-400">None</div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <p class="text-[0.45rem] mt-1 italic leading-tight">{{ $card->description }}</p>

            <!-- Card Info -->
            <div class="text-[0.4rem] mt-1 flex justify-between items-end opacity-80">
                <div>
                    Illus. {{ $card->artist }} ©{{ $card->year }} Nintendo, Creatures, GAMEFREAK. ©{{ $card->year }} Pokémon.
                </div>
                <div>{{ $card->card_number }}/{{ $card->set }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-center space-x-4">
        <a href="{{ route('cards.index') }}" 
           class="text-sm text-gray-600 hover:text-gray-800">
            Back to List
        </a>
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
    </div>
</div>

<style>
@font-face {
    font-family: 'Pokemon GB';
    src: url('https://cdn.jsdelivr.net/npm/pokemon-font@1.8.1/fonts/pokemon-font.woff2') format('woff2');
}

@font-face {
    font-family: 'Gill Sans Condensed';
    src: local('Gill Sans Condensed'), local('GillSans-Condensed');
}

.pokemon-card {
    box-shadow: 
        0 0 0 1px rgba(0,0,0,0.1),
        0 2px 4px rgba(0,0,0,0.1),
        0 4px 8px rgba(0,0,0,0.1),
        inset 0 0 60px rgba(255,255,255,0.2),
        inset 0 0 15px rgba(255,255,255,0.1);
    animation: holo 6s ease infinite;
    transform-style: preserve-3d;
    perspective: 1000px;
}

@keyframes holo {
    0%, 100% {
        filter: brightness(98%) contrast(105%) saturate(105%);
        transform: rotateY(0deg) rotateX(0deg);
    }
    25% {
        filter: brightness(102%) contrast(110%) saturate(110%);
        transform: rotateY(2deg) rotateX(-1deg);
    }
    75% {
        filter: brightness(102%) contrast(110%) saturate(110%);
        transform: rotateY(-2deg) rotateX(1deg);
    }
}

.type-icon {
    position: relative;
    overflow: hidden;
}

.type-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, transparent 50%);
    mix-blend-mode: overlay;
}

.pokemon-name {
    font-family: 'Pokemon GB', monospace;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
    letter-spacing: 0.5px;
}

.card-title {
    font-family: 'Gill Sans Condensed', 'Arial Narrow', sans-serif;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.attack-name {
    font-family: 'Gill Sans Condensed', 'Arial Narrow', sans-serif;
    font-weight: 600;
}

.damage-text {
    font-family: 'Futura', 'Trebuchet MS', sans-serif;
    font-weight: bold;
}

.card-frame {
    background: repeating-linear-gradient(
        -45deg,
        rgba(255,255,255,0.05),
        rgba(255,255,255,0.05) 8px,
        transparent 8px,
        transparent 16px
    );
}

.image-frame {
    box-shadow: 
        inset 0 0 10px rgba(0,0,0,0.3),
        0 1px 2px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #f0f0e8, #e8e8d8);
}

.energy-symbol {
    position: relative;
    overflow: hidden;
    box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
}

.energy-symbol::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, transparent 50%);
    mix-blend-mode: overlay;
}
</style>
@endsection
