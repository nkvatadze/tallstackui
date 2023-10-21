@php
    $customize = tallstackui_personalization('wrapper.select', $personalization());
    $error = $computed && $errors->has($computed);
@endphp

<div x-data="{!! $alpine !!}" x-cloak>
    @if ($label)
        <x-label :$label :$error/>
    @endif
    <div class="relative" x-on:click.outside="show = false">
        <button type="button"
                @disabled($disabled)
                @class([$customize['select.wrapper'], 'ring-gray-300 dark:ring-dark-600' => !$error, $customize['select.error'] => $error])
                @if (!$disabled) x-on:click="show = !show" @endif
                aria-haspopup="listbox"
                :aria-expanded="show"
                dusk="tallstackui_select_open_close">
            <div @class($customize['header'])>
                {!! $header !!}
            </div>
            @if (!$disabled)
            <div @class($customize['buttons.wrapper'])>
                <template x-if="!empty">
                    <button dusk="tallstackui_select_clear" type="button" x-on:click="clear(); show = true">
                        <x-icon name="x-mark" @class([
                            $customize['buttons.size'],
                            $customize['buttons.base'] => !$error,
                            $customize['buttons.error'] => $error
                        ]) />
                    </button>
                </template>
                <x-icon name="chevron-up-down" @class([
                    $customize['buttons.size'],
                    $customize['buttons.base'] => !$error,
                    $customize['buttons.error'] => $error
                ]) />
            </div>
            @endif
        </button>
        <div wire:ignore x-show="show" x-cloak style="display: none;" @class($customize['box.wrapper']) x-ref="select">
            <template x-if="searchable">
                <div class="relative px-2 my-2">
                    <x-input placeholder="{{ $placeholder['input'] }}"
                             x-model.debounce.500ms="search"
                             x-ref="search"
                             dusk="tallstackui_select_search_input"
                             :validate="false"
                    />
                    <button type="button"
                            @class([$customize['box.button.class']])
                            x-on:click="search = ''; $refs.search.focus();"
                            x-show="search.length > 0">
                        <x-icon name="x-mark" @class($customize['box.button.icon']) />
                    </button>
                </div>
            </template>
            <ul @class($customize['box.list.wrapper']) dusk="tallstackui_select_options" role="listbox">
                @if ($loading)
                    <div x-show="loading"
                        @class($customize['box.list.loading.wrapper']) class="flex items-center justify-center p-4 space-x-4">
                        <svg @class($customize['box.list.loading.class'])
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                @endif
                <template x-for="(option, index) in options" :key="option[selectable.label] ?? option">
                    <li x-on:click="select(option)"
                        x-on:keypress.enter="select(option)"
                        x-bind:class="{ 'font-semibold hover:text-white hover:bg-red-500 dark:hover:bg-red-500': selected(option) }"
                        role="option"
                        @class($customize['box.list.item.wrapper'])
                    >
                        <div wire:ignore @class($customize['box.list.item.class'])>
                            <span class="ml-2 truncate" x-text="option[selectable.label] ?? option"></span>
                            <x-icon name="check" x-show="selected(option)" class="h-5 w-5 font-bold"/>
                        </div>
                    </li>
                </template>
                @if (!$after)
                <template x-if="!loading && options.length === 0">
                    <li class="m-2">
                        <span @class($customize['message'])>
                            {{ $placeholder['empty'] }}
                        </span>
                    </li>
                </template>
                @endif
                <div x-show="!loading && options.length === 0">
                    {!! $after !!}
                </div>
            </ul>
        </div>
    </div>
    @if ($hint && !$error)
        <x-hint :$hint/>
    @endif
    @if ($error && $computed)
        <x-error :$computed :$error/>
    @endif
</div>