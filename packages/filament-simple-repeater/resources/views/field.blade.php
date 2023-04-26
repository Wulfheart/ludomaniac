<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div {{ $attributes->merge($getExtraAttributes())->class(['space-y-6', 'filament-forms-simple-repeater-component']) }}>
        <ul
            class="space-y-2"
            wire:sortable
            wire:end.stop="dispatchFormEvent('simple-repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
        >
            @foreach($getChildComponentContainers() as $uuid => $container)
                <li
                    wire:key="{{ $container->getStatePath() }}"
                    wire:sortable.item="{{ $uuid }}"
                    class="relative"
                >
                    @if(! $isItemDeletionDisabled() || (! $isItemMovementDisabled() && ($loop->count > 1)))
                        <div class="flex items-center justify-end pr-4">
                            <div @class([
                                'w-max bg-gray-50 h-6 flex divide-x rounded-t-lg border-gray-300 border-t border-r border-l overflow-hidden rtl:border-l-0 rtl:border-r rtl:right-auto rtl:left-0 rtl:rounded-bl-none rtl:rounded-br-lg rtl:rounded-tr-none rtl:rounded-tl-lg',
                                'dark:border-gray-600 dark:divide-gray-600' => config('forms.dark_mode'),
                            ])>
                                @if(! $isItemMovementDisabled() && $loop->count > 1)
                                    <button
                                        wire:sortable.handle
                                        wire:keydown.prevent.arrow-up="dispatchFormEvent('repeater::moveItemUp', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                        wire:keydown.prevent.arrow-down="dispatchFormEvent('repeater::moveItemDown', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                        type="button"
                                        @class([
                                            'flex items-center justify-center w-6 text-gray-800 cursor-grab hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset focus:ring-white focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600',
                                            'dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:text-primary-600' => config('forms.dark_mode'),
                                        ])
                                    >
                                        <span class="sr-only">
                                            {{ __('forms::components.repeater.buttons.move_item_down.label') }}
                                        </span>
                                        <div class="flex flex-col">
                                            <x-heroicon-o-dots-horizontal class="w-4 h-4" />
                                            <x-heroicon-o-dots-horizontal class="w-4 h-4 -mt-[0.6875rem]" />
                                        </div>
                                    </button>
                                @endunless

                                @unless ($isItemDeletionDisabled())
                                    <button
                                        wire:click="dispatchFormEvent('simple-repeater::deleteItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                        type="button"
                                        @class([
                                            'flex items-center justify-center w-6 text-danger-600 hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset focus:ring-white focus:ring-primary-600 focus:text-danger-600 focus:bg-primary-50 focus:border-primary-600',
                                            'dark:hover:bg-gray-600' => config('forms.dark_mode'),
                                        ])
                                    >
                                        <span class="sr-only">
                                            {{ __('forms::components.repeater.buttons.delete_item.label') }}
                                        </span>
                                        <x-heroicon-s-trash class="w-4 h-4" />
                                    </button>
                                @endunless
                            </div>
                        </div>
                    @endunless

                    {{ $container }}
                </li>
            @endforeach
        </ul>

        @if(! $shouldHideAddItemButton())
            <div class="relative flex justify-center">
                <x-forms::button
                    wire:click="dispatchFormEvent('simple-repeater::addItem', '{{ $getStatePath() }}')"
                    type="button"
                    size="sm"
                >
                    <span>
                        {{ $getAddItemButtonLabel() }}
                    </span>
                </x-forms::button>
            </div>
        @endif
    </div>
</x-forms::field-wrapper>
