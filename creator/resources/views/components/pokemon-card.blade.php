@props([
    'card',
    'isLink' => true,
    'showHoverEffect' => true
])

@php
    $baseClasses = 'pokemon-card w-[245px] h-[342px] relative rounded-[0.9rem] overflow-hidden';
    $hoverClasses = $showHoverEffect ? 'hover:scale-[1.02] hover:-translate-y-1 transition-transform duration-300' : '';
@endphp

<div {{ $attributes->merge(['class' => "{$baseClasses} {$hoverClasses}"]) }}
     style="background: 
        linear-gradient(135deg, 
            @if($card->type == 'Electric') #FCD000, #FFE65D
            @elseif($card->type == 'Fighting') #CE4265, #E87F8B
            @elseif($card->type == 'Water') #419BF9, #7AC7FF
            @elseif($card->type == 'Fire') #FF9D55, #FFAC6B
            @else #A5A5A5, #D4D4D4
            @endif);">
    <div class="card-frame absolute inset-0 border-[3px] rounded-[0.9rem] border-yellow-300/30"></div>
    <div class="card-texture absolute inset-0 mix-blend-soft-light"></div>
    
    @if($isLink)
        <a href="{{ route('cards.show', $card->id) }}" class="block relative p-3 h-full flex flex-col bg-white/5">
    @else
        <div class="relative p-3 h-full flex flex-col bg-white/5">
    @endif
        <!-- Card Header -->
        <div class="flex justify-between items-center mb-1">
            <div class="flex items-center gap-1">
                <span class="card-title text-[0.7rem] font-futura tracking-wide">Basic</span>
                <span class="card-title text-[0.7rem] font-futura tracking-wide">Pokémon</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="card-title text-base font-futura text-red-600 font-bold tracking-tight">{{ $card->hp }} HP</span>
                <div class="type-icon w-6 h-6 rounded-full flex items-center justify-center shadow-inner
                    @if($card->type == 'Electric') bg-[#FCD000]
                    @elseif($card->type == 'Fighting') bg-[#CE4265]
                    @elseif($card->type == 'Water') bg-[#419BF9]
                    @elseif($card->type == 'Fire') bg-[#FF9D55]
                    @else bg-[#A5A5A5]
                    @endif">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-white drop-shadow" xmlns="http://www.w3.org/2000/svg">
                        @if($card->type == 'Electric')
                            <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                        @elseif($card->type == 'Fighting')
                            <path d="M15 2l-3 9h5l-7 11 2-9h-5l3-11z"/>
                        @elseif($card->type == 'Water')
                            <path d="M12 2c-1.2 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-2.8-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                        @elseif($card->type == 'Fire')
                            <path d="M12 2c0 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-4-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                        @else
                            <circle cx="12" cy="12" r="8"/>
                        @endif
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pokemon Name -->
        <h2 class="pokemon-name text-base font-bold mb-1 tracking-wide uppercase">{{ $card->name }}</h2>

        <!-- Image Frame -->
        <div class="relative mb-2">
            <div class="absolute inset-0 border-[5px] border-[#D4B03C] rounded-sm z-10"></div>
            <div class="image-frame h-36 rounded-sm overflow-hidden relative bg-gradient-to-br from-[#F8E8B0] to-[#F0D890]">
                @if($card->image_url)
                    <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
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
                            <div class="energy-symbol w-4 h-4 rounded-full flex items-center justify-center shadow-inner
                                @if($card->type == 'Electric') bg-[#FCD000]
                                @elseif($card->type == 'Fighting') bg-[#CE4265]
                                @elseif($card->type == 'Water') bg-[#419BF9]
                                @elseif($card->type == 'Fire') bg-[#FF9D55]
                                @else bg-[#A5A5A5]
                                @endif">
                                <svg viewBox="0 0 24 24" class="w-3 h-3 fill-white drop-shadow" xmlns="http://www.w3.org/2000/svg">
                                    @if($card->type == 'Electric')
                                        <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                                    @elseif($card->type == 'Fighting')
                                        <path d="M15 2l-3 9h5l-7 11 2-9h-5l3-11z"/>
                                    @elseif($card->type == 'Water')
                                        <path d="M12 2c-1.2 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-2.8-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                    @elseif($card->type == 'Fire')
                                        <path d="M12 2c0 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-4-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                    @else
                                        <circle cx="12" cy="12" r="8"/>
                                    @endif
                                </svg>
                            </div>
                        @endfor
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-center">
                            <span class="attack-name text-[0.7rem]">{{ $attack['name'] }}</span>
                            <span class="damage-text text-[0.7rem]">{{ $attack['damage'] }}</span>
                        </div>
                        @if(!$isLink)
                            <p class="text-[0.6rem] leading-tight mt-0.5">{{ $attack['description'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(!$isLink)
            <!-- Stats -->
            <div class="grid grid-cols-3 text-[0.5rem] border-t border-black/10 pt-1 mt-auto">
                <div>
                    <span class="text-gray-600 block">weakness</span>
                    @if($card->weakness)
                        <div class="type-icon mt-1 inline-flex items-center justify-center w-4 h-4 rounded-full shadow-inner
                            @if($card->weakness == 'Electric') bg-[#FCD000]
                            @elseif($card->weakness == 'Fighting') bg-[#CE4265]
                            @elseif($card->weakness == 'Water') bg-[#419BF9]
                            @elseif($card->weakness == 'Fire') bg-[#FF9D55]
                            @else bg-[#A5A5A5]
                            @endif">
                            <svg viewBox="0 0 24 24" class="w-3 h-3 fill-white drop-shadow" xmlns="http://www.w3.org/2000/svg">
                                @if($card->weakness == 'Electric')
                                    <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                                @elseif($card->weakness == 'Fighting')
                                    <path d="M15 2l-3 9h5l-7 11 2-9h-5l3-11z"/>
                                @elseif($card->weakness == 'Water')
                                    <path d="M12 2c-1.2 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-2.8-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                @elseif($card->weakness == 'Fire')
                                    <path d="M12 2c0 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-4-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                @else
                                    <circle cx="12" cy="12" r="8"/>
                                @endif
                            </svg>
                        </div>
                    @else
                        <div class="mt-1 text-gray-400">None</div>
                    @endif
                </div>
                <div>
                    <span class="text-gray-600 block">resistance</span>
                    @if($card->resistance)
                        <div class="type-icon mt-1 inline-flex items-center justify-center w-4 h-4 rounded-full shadow-inner
                            @if($card->resistance == 'Electric') bg-[#FCD000]
                            @elseif($card->resistance == 'Fighting') bg-[#CE4265]
                            @elseif($card->resistance == 'Water') bg-[#419BF9]
                            @elseif($card->resistance == 'Fire') bg-[#FF9D55]
                            @else bg-[#A5A5A5]
                            @endif">
                            <svg viewBox="0 0 24 24" class="w-3 h-3 fill-white drop-shadow" xmlns="http://www.w3.org/2000/svg">
                                @if($card->resistance == 'Electric')
                                    <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
                                @elseif($card->resistance == 'Fighting')
                                    <path d="M15 2l-3 9h5l-7 11 2-9h-5l3-11z"/>
                                @elseif($card->resistance == 'Water')
                                    <path d="M12 2c-1.2 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-2.8-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                @elseif($card->resistance == 'Fire')
                                    <path d="M12 2c0 4-4 7-4 10 0 3.3 2.7 6 6 6s6-2.7 6-6c0-3-4-6-4-10zm0 14c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                                @else
                                    <circle cx="12" cy="12" r="8"/>
                                @endif
                            </svg>
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
                                <div class="energy-symbol w-3 h-3 rounded-full flex items-center justify-center shadow-inner bg-[#A5A5A5]">
                                    <svg viewBox="0 0 24 24" class="w-2 h-2 fill-white drop-shadow" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="8"/>
                                    </svg>
                                </div>
                            @endfor
                        </div>
                    @else
                        <div class="mt-1 text-gray-400">None</div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <p class="text-[0.45rem] mt-1 italic leading-tight">{{ $card->description }}</p>
        @endif

        <!-- Card Info -->
        <div class="text-[0.4rem] mt-1 flex justify-between items-end opacity-80">
            @if($isLink)
                <div>{{ $card->set }} · {{ $card->card_number }}</div>
                <div>Illus. {{ $card->artist }}</div>
            @else
                <div>
                    Illus. {{ $card->artist }} ©{{ $card->year }} Nintendo, Creatures, GAMEFREAK. ©{{ $card->year }} Pokémon.
                </div>
                <div>{{ $card->card_number }}/{{ $card->set }}</div>
            @endif
        </div>

    @if($isLink)
        </a>
    @else
        </div>
    @endif
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');

.pokemon-card {
    box-shadow: 
        0 0 0 1px rgba(0,0,0,0.1),
        0 2px 4px rgba(0,0,0,0.1),
        0 4px 8px rgba(0,0,0,0.1),
        inset 0 0 30px rgba(255,255,255,0.5),
        inset 0 0 2px rgba(255,255,255,0.8);
    animation: holo 15s ease infinite;
    transform-style: preserve-3d;
    perspective: 1000px;
}

.card-texture {
    background: repeating-linear-gradient(
        -45deg,
        rgba(255,255,255,0.1) 0px,
        rgba(255,255,255,0.1) 2px,
        transparent 2px,
        transparent 4px
    );
}

@keyframes holo {
    0%, 100% {
        filter: brightness(100%) contrast(100%) saturate(100%) hue-rotate(0deg);
        transform: rotateY(0deg) rotateX(0deg);
    }
    25% {
        filter: brightness(115%) contrast(105%) saturate(110%) hue-rotate(5deg);
        transform: rotateY(3deg) rotateX(-2deg);
    }
    75% {
        filter: brightness(115%) contrast(105%) saturate(110%) hue-rotate(-5deg);
        transform: rotateY(-3deg) rotateX(2deg);
    }
}

.pokemon-name {
    font-family: 'Roboto Condensed', sans-serif;
    font-weight: 700;
    text-shadow: 1px 1px 0 rgba(0,0,0,0.2);
    letter-spacing: 0.5px;
}

.font-futura {
    font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
}

.card-frame {
    background: linear-gradient(135deg, rgba(255,255,255,0.5), rgba(255,255,255,0.2));
    box-shadow: inset 0 0 2px rgba(255,255,255,0.5);
}

.image-frame {
    box-shadow: 
        inset 0 0 10px rgba(0,0,0,0.2),
        0 1px 2px rgba(0,0,0,0.1);
}

.attack-name {
    font-family: 'Roboto Condensed', sans-serif;
    font-weight: 700;
}

.damage-text {
    font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
    font-weight: bold;
}

.type-icon, .energy-symbol {
    position: relative;
}

.type-icon::before, .energy-symbol::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, transparent 50%);
    border-radius: inherit;
    mix-blend-mode: overlay;
}
</style>
