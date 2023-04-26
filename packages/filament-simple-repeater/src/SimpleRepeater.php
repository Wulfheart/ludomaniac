<?php

namespace RyanChandler\FilamentSimpleRepeater;

use Closure;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Concerns\CanLimitItemsLength;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\RelationshipRepeater;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SimpleRepeater extends Field
{
    use CanLimitItemsLength;

    protected string $view = 'filament-simple-repeater::field';

    protected Field | Closure $field;

    protected string | Closure | null $addItemButtonLabel = null;

    protected bool | Closure $isItemMovementDisabled = false;

    protected bool | Closure $isItemDeletionDisabled = false;

    protected bool | Closure $hideAddItemButtonWhenMaxItemsReached = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultItems(1);

        $this->afterStateHydrated(function (SimpleRepeater $component, ?array $state): void {
            if ($component->getContainer()->getParentComponent() instanceof RelationshipRepeater) {
                return;
            }

            $field = $component->getField();

            $items = collect($state ?? [])
                ->when(function (Collection $collection) {
                    return ! is_array($collection->first());
                }, function (Collection $collection) use ($field) {
                    return $collection->map(fn ($item) => [
                        $field->getName() => $item,
                    ]);
                })
                ->mapWithKeys(fn ($itemData) => [(string) Str::uuid() => $itemData])
                ->toArray();

            $component->state($items);
        });

        $this->registerListeners([
            'simple-repeater::deleteItem' => [
                function (SimpleRepeater $component, string $statePath, string $uuid): void {
                    if ($component->isDisabled()) {
                        return;
                    }

                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $items = $component->getState();

                    unset($items[$uuid]);

                    $livewire = $component->getLivewire();
                    data_set($livewire, $statePath, $items);
                },
            ],
            'simple-repeater::addItem' => [
                function (SimpleRepeater $component, string $statePath): void {
                    if ($component->isDisabled()) {
                        return;
                    }

                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $uuid = (string) Str::uuid();

                    $livewire = $component->getLivewire();
                    data_set($livewire, "{$statePath}.{$uuid}", null);

                    $component->getChildComponentContainers()[$uuid]->fill();
                },
            ],
            'simple-repeater::moveItems' => [
                function (SimpleRepeater $component, string $statePath, array $uuids): void {
                    if ($component->isDisabled()) {
                        return;
                    }

                    if ($component->isItemMovementDisabled()) {
                        return;
                    }

                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $items = array_merge(array_flip($uuids), $component->getState());

                    $livewire = $component->getLivewire();
                    data_set($livewire, $statePath, $items);
                },
            ],
        ]);

        $this->addItemButtonLabel(function (SimpleRepeater $component) {
            return __('forms::components.repeater.buttons.create_item.label', [
                'label' => lcfirst($component->getLabel()),
            ]);
        });

        $this->loadStateFromRelationshipsUsing(function (SimpleRepeater $component, ?array $state) {
            if (! $component->getContainer()->getParentComponent() instanceof RelationshipRepeater) {
                return;
            }

            $field = $component->getField();

            $items = collect($state ?? [])
                ->map(fn ($item) => [$field->getName() => $item])
                ->mapWithKeys(fn ($itemData) => [(string) Str::uuid() => $itemData])
                ->toArray();

            $component->state($items);
        });

        $this->mutateDehydratedStateUsing(function (SimpleRepeater $component, ?array $state): array {
            return collect($state)->values()->pluck($component->getField()->getName())->toArray();
        });
    }

    public function disableItemMovement(bool | Closure $condition = true): static
    {
        $this->isItemMovementDisabled = $condition;

        return $this;
    }

    public function disableItemDeletion(bool | Closure $condition = true): static
    {
        $this->isItemDeletionDisabled = $condition;

        return $this;
    }

    public function isItemDeletionDisabled(): bool
    {
        return (bool) $this->evaluate($this->isItemDeletionDisabled);
    }

    public function isItemMovementDisabled(): bool
    {
        return (bool) $this->evaluate($this->isItemMovementDisabled);
    }

    public function defaultItems(int | Closure $count): static
    {
        $this->default(function (SimpleRepeater $component) use ($count): array {
            $items = [];
            $count = $component->evaluate($count);

            if (! $count) {
                return $items;
            }

            foreach (range(1, $count) as $_) {
                $items[] = null;
            }

            return $items;
        });

        return $this;
    }

    public function hideAddItemButtonWhenMaxItemsReached(bool | Closure $condition = true): static
    {
        $this->hideAddItemButtonWhenMaxItemsReached = $condition;

        return $this;
    }

    public function shouldHideAddItemButton(): bool
    {
        return ($this->getMaxItems() !== null) &&
            (bool) $this->evaluate($this->hideAddItemButtonWhenMaxItemsReached) &&
            ($this->getItemsCount() === $this->getMaxItems());
    }

    public function addItemButtonLabel(string | Closure | null $label): static
    {
        $this->addItemButtonLabel = $label;

        return $this;
    }

    /** @deprecated Use `addItemButtonLabel()` instead. */
    public function createItemButtonLabel(string | Closure | null $label): static
    {
        return $this->addItemButtonLabel($label);
    }

    public function getAddItemButtonLabel(): string
    {
        return $this->evaluate($this->addItemButtonLabel);
    }

    /** @deprecated Use `getAddItemButtonLabel()` instead. */
    public function getCreateItemButtonLabel(): string
    {
        return $this->getAddItemButtonLabel();
    }

    public function field(Field | Closure $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): Field
    {
        return $this
            ->evaluate($this->field)
            ->disableLabel();
    }

    public function hydrateDefaultItemState(string $uuid): void
    {
        $this->getChildComponentContainers()[$uuid]->hydrateDefaultState();
    }

    public function getChildComponentContainers(bool $withHidden = false): array
    {
        return collect($this->getState())
            ->map(function ($_, $itemIndex): ComponentContainer {
                return $this
                    ->getChildComponentContainer()
                    ->getClone()
                    ->components([
                        $this->getField(),
                    ])
                    ->statePath($itemIndex);
            })
            ->toArray();
    }
}
