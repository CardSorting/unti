@extends('layouts.app')

@section('content')
    <div class="pokemon-card-form">
        <div class="pokemon-card-form__container">
            <div class="pokemon-card-form__grid" x-data="{ 
                    isSubmitting: false,
                    currentStep: 1,
                    attacks: [{ name: '', damage: '0', energyCount: 1, description: '' }],
                    isStepValid: {
                        1: false,
                        2: false,
                        3: false,
                        4: false
                    },
                    validateStep(step) {
                        if (step === 1) {
                            this.isStepValid[1] = Boolean(
                                this.cardData.name && 
                                this.cardData.type && 
                                this.cardData.hp && 
                                this.cardData.category && 
                                this.cardData.description
                            );
                        } else if (step === 2) {
                            this.isStepValid[2] = this.attacks.some(attack => 
                                Boolean(attack.name?.trim()) && 
                                Number(attack.damage) >= 0 && 
                                Number(attack.energyCount) >= 1 && 
                                Number(attack.energyCount) <= 4 &&
                                Boolean(attack.description?.trim())
                            );
                        } else if (step === 3) {
                            this.isStepValid[3] = Boolean(
                                this.cardData.weakness !== undefined && 
                                this.cardData.resistance !== undefined && 
                                this.cardData.retreat_cost !== undefined &&
                                Number(this.cardData.retreat_cost) >= 0 &&
                                Number(this.cardData.retreat_cost) <= 4
                            );
                        } else if (step === 4) {
                            const currentYear = new Date().getFullYear();
                            this.isStepValid[4] = Boolean(
                                this.cardData.card_number?.trim() && 
                                this.cardData.artist?.trim() && 
                                this.cardData.set?.trim() && 
                                Number(this.cardData.year) >= 1996 &&
                                Number(this.cardData.year) <= currentYear
                            );
                        }
                    },
                    cardData: {
                        name: '',
                        type: '',
                        hp: '',
                        category: '',
                        length: '',
                        weight: '',
                        description: '',
                        attacks: [],
                        weakness: '',
                        resistance: '',
                        retreat_cost: '',
                        card_number: '',
                        artist: '',
                        set: '',
                        year: new Date().getFullYear()
                    }
                }"
                x-init="
                    $watch('cardData', value => {
                        cardData.attacks = attacks;
                        validateStep(currentStep);
                    }, { deep: true });
                    $watch('attacks', value => {
                        validateStep(2);
                        cardData.attacks = value;
                    }, { deep: true });
                    $watch('currentStep', value => {
                        validateStep(value);
                        if (value !== 2) {
                            attacks = attacks.filter(attack => 
                                attack.name?.trim() && 
                                Number(attack.damage) >= 0 && 
                                Number(attack.energyCount) >= 1 && 
                                Number(attack.energyCount) <= 4 &&
                                attack.description?.trim()
                            );
                            if (attacks.length === 0) {
                                attacks.push({ name: '', damage: '0', energyCount: 1, description: '' });
                            }
                        }
                    });">

                <div class="col-span-12">
                    <h2 class="pokemon-card-form__title">Create New Pokemon Card</h2>
                </div>

                <form action="{{ route('cards.store') }}" method="POST" class="col-span-8"
                      @submit.prevent="
                        if(currentStep !== 4) { 
                            return;
                        }
                        if(!isStepValid[1] || !isStepValid[2] || !isStepValid[3] || !isStepValid[4]) {
                            return;
                        }
                        isSubmitting = true;
                        $el.submit();
                      "
                      @keydown.meta.s.prevent="$event.preventDefault()"
                      @keydown.ctrl.s.prevent="$event.preventDefault()"
                      @keydown.meta.enter="if(isStepValid[currentStep]) currentStep++"
                      @keydown.ctrl.enter="if(isStepValid[currentStep]) currentStep++">

                    <x-cards.form-layout>
                        <x-cards.form-steps 
                            x-bind:current-step="currentStep" 
                            x-bind:is-step-valid="isStepValid" />

                        <div class="space-y-8" :class="{ 'opacity-50 pointer-events-none': isSubmitting }">
                            <x-cards.form-sections.general x-bind:card-data="cardData" />
                            <x-cards.form-sections.attacks x-bind:attacks="attacks" />
                            <x-cards.form-sections.stats x-bind:card-data="cardData" />
                            <x-cards.form-sections.card-info x-bind:card-data="cardData" />
                        </div>

                        <x-cards.form-navigation 
                            x-bind:current-step="currentStep"
                            x-bind:is-step-valid="isStepValid"
                            x-bind:is-submitting="isSubmitting" />
                    </x-cards.form-layout>
                </form>

                <div class="col-span-4">
                    <x-cards.preview x-bind:form-data="{ cardData: cardData, attacks: attacks }" />
                </div>
            </div>
        </div>
    </div>
@endsection
