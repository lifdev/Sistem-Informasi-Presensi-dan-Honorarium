<div
    {{ $attributes->merge([
        'class' => 'rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700',
    ]) }}>
    {{ $slot }}
</div>
