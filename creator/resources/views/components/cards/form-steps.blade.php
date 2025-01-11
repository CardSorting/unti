@props(['currentStep', 'isStepValid'])

<div>
    <!-- Progress Bar -->
    <div class="pokemon-card-form__progress">
        <div class="flex justify-between text-sm text-gray-600">
            <span>Progress</span>
            <span x-text="Object.values(isStepValid).filter(Boolean).length + '/4 steps completed'"></span>
        </div>
        <div class="pokemon-card-form__progress-bar">
            <div class="pokemon-card-form__progress-fill"
                 :style="'width: ' + (Object.values(isStepValid).filter(Boolean).length * 25) + '%'">
            </div>
        </div>
    </div>

    <!-- Steps Navigation -->
    <nav class="pokemon-card-form__steps">
        <ol class="flex items-center w-full">
            <template x-for="(step, index) in ['General', 'Attacks', 'Stats', 'Card Info']" :key="index">
                <li class="flex items-center w-full" :class="{'opacity-75': currentStep < index + 1}">
                    <div class="flex flex-col items-center flex-1">
                        <button type="button"
                                @click="currentStep = index + 1"
                                @keydown.arrow-right="currentStep < 4 && currentStep++"
                                @keydown.arrow-left="currentStep > 1 && currentStep--"
                                :class="{
                                    'pokemon-card-form__step-button': true,
                                    'pokemon-card-form__step-button--current': currentStep === index + 1,
                                    'pokemon-card-form__step-button--completed': isStepValid[index + 1] && currentStep !== index + 1,
                                    'pokemon-card-form__step-button--incomplete': !isStepValid[index + 1] && currentStep !== index + 1
                                }">
                            <span x-text="index + 1"></span>
                        </button>
                        <span class="text-sm mt-2" x-text="step"></span>
                        <template x-if="index < 3">
                            <div class="w-full h-1 bg-gray-200 mt-4">
                                <div class="h-1 bg-blue-600 transition-all duration-500"
                                     :style="'width: ' + (currentStep > index + 1 ? '100' : currentStep === index + 1 ? '50' : '0') + '%'">
                                </div>
                            </div>
                        </template>
                    </div>
                </li>
            </template>
        </ol>
    </nav>

    <!-- Keyboard Shortcuts Help -->
    <div class="pokemon-card-form__shortcuts">
        <div class="flex items-center space-x-4">
            <span class="font-medium">Keyboard shortcuts:</span>
            <span><kbd class="px-2 py-1 bg-white rounded shadow">←</kbd> Previous step</span>
            <span><kbd class="px-2 py-1 bg-white rounded shadow">→</kbd> Next step</span>
            <span><kbd class="px-2 py-1 bg-white rounded shadow">⌘/Ctrl + ↵</kbd> Next step</span>
        </div>
    </div>
</div>
