@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 p-4">
        @forelse ($cards as $card)
            <div class="pokemon-card w-[252px] h-[352px] relative rounded-[0.75rem] overflow-hidden mx-auto"
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
                <a href="{{ route('cards.show', $card->id) }}" class="block relative p-3 h-full flex flex-col bg-white/5">
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

                    <!-- Image -->
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

                    <!-- Attacks Preview -->
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
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Card Info -->
                    <div class="text-[0.4rem] mt-1 flex justify-between items-end opacity-80">
                        <div>{{ $card->set }} · {{ $card->card_number }}</div>
                        <div>Illus. {{ $card->artist }}</div>
                    </div>

                    <!-- Actions -->
                    <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-200">
                        <div class="flex gap-4">
                            <a href="{{ route('cards.edit', $card->id) }}"
                               class="text-white hover:text-yellow-200 bg-black/50 px-4 py-2 rounded">
                                Edit
                            </a>
                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-white hover:text-red-200 bg-black/50 px-4 py-2 rounded"
                                        onclick="return confirm('Are you sure you want to delete this card?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
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
        transition: transform 0.3s ease;
    }

    .pokemon-card:hover {
        transform: scale(1.02) translateY(-4px) rotateX(5deg);
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
