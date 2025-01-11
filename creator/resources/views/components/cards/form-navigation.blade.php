<div class="pokemon-card-form__navigation">
    <div>
        <button type="button" 
                x-show="currentStep > 1"
                @click="currentStep--"
                :disabled="!isStepValid[currentStep - 1] || isSubmitting"
                class="pokemon-card-form__button pokemon-card-form__button--secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Previous
        </button>
    </div>
    <div class="flex space-x-4">
        <template x-if="currentStep < 4">
            <button type="button" 
                    @click="currentStep++"
                    :disabled="!isStepValid[currentStep] || isSubmitting"
                    class="pokemon-card-form__button pokemon-card-form__button--primary">
                Next
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </template>
        <template x-if="currentStep === 4">
            <div class="flex space-x-4">
                <a href="{{ route('cards.index') }}" 
                   class="pokemon-card-form__button pokemon-card-form__button--secondary"
                   :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="pokemon-card-form__button pokemon-card-form__button--primary"
                        :disabled="!isStepValid[1] || !isStepValid[2] || !isStepValid[3] || !isStepValid[4] || isSubmitting">
                    <template x-if="!isSubmitting">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                    <template x-if="isSubmitting">
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </template>
                    <span x-text="isSubmitting ? 'Creating...' : 'Create Card'"></span>
                </button>
            </div>
        </template>
    </div>
</div>
