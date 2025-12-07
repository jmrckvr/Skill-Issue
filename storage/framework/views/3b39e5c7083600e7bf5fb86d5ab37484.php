<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'info', 'dismissible' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['type' => 'info', 'dismissible' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colors = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-900',
        'success' => 'bg-green-50 border-green-200 text-green-900',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-900',
        'error' => 'bg-red-50 border-red-200 text-red-900',
    ];
    $color = $colors[$type] ?? $colors['info'];
?>

<div id="alert-<?php echo e(uniqid()); ?>" class="p-4 rounded-lg border <?php echo e($color); ?> <?php echo e($dismissible ? 'relative' : ''); ?>">
    <div class="flex gap-3">
        <div class="flex-1">
            <?php echo e($slot); ?>

        </div>
        <?php if($dismissible): ?>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/components/alert.blade.php ENDPATH**/ ?>