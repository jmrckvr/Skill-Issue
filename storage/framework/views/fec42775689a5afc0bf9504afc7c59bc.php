<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['job', 'clickable' => true, 'sidebar' => false]));

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

foreach (array_filter((['job', 'clickable' => true, 'sidebar' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
    'bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 job-card',
    'cursor-pointer hover:border-blue-400 transform hover:-translate-y-1' => $clickable && $sidebar,
]); ?>" data-job-id="<?php echo e($job->id); ?>" style="pointer-events: auto; cursor: pointer; <?php if($sidebar): ?> cursor: pointer; <?php endif; ?>">
    <!-- Header with Company Logo and Title -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">
                <?php echo e($job->title); ?>

            </h3>
            <p class="text-sm text-gray-600"><?php echo e($job->company->name); ?></p>
        </div>
        <?php
            $logoUrl = null;
            if ($job->logo) {
                $logoUrl = str_starts_with($job->logo, 'http') ? $job->logo : asset('storage/' . $job->logo);
            } elseif ($job->company->logo_path) {
                $logoUrl = str_starts_with($job->company->logo_path, 'http') ? $job->company->logo_path : asset('storage/' . $job->company->logo_path);
            }
        ?>

        <?php if($logoUrl): ?>
            <img
                src="<?php echo e($logoUrl); ?>"
                alt="<?php echo e($job->company->name); ?>"
                class="w-14 h-14 rounded-lg object-cover ml-4 flex-shrink-0"
                loading="lazy"
                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2256%22 height=%2256%22 viewBox=%220 0 56 56%22%3E%3Crect width=%2256%22 height=%2256%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'"
            />
        <?php else: ?>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center flex-shrink-0 ml-4">
                <span class="text-blue-600 font-bold text-sm"><?php echo e(substr($job->company->name, 0, 2)); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tags -->
    <div class="flex flex-wrap gap-2 mb-4">
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold cursor-pointer hover:opacity-80 transition',
            'bg-blue-100 text-blue-700' => $job->job_type === 'full-time',
            'bg-green-100 text-green-700' => $job->job_type === 'part-time',
            'bg-purple-100 text-purple-700' => $job->job_type === 'contract',
            'bg-yellow-100 text-yellow-700' => in_array($job->job_type, ['temporary', 'freelance']),
        ]); ?>">
            <?php echo e(ucfirst($job->job_type)); ?>

        </span>

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 cursor-pointer hover:opacity-80 transition">
            <?php echo e(ucfirst($job->experience_level)); ?>

        </span>

        <?php if($job->category): ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 cursor-pointer hover:opacity-80 transition">
                <?php echo e($job->category->icon); ?> <?php echo e($job->category->name); ?>

            </span>
        <?php endif; ?>
    </div>

    <!-- Location and Meta Info -->
    <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span><?php echo e($job->location); ?></span>
        </div>
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>
                <?php if(!$job->hide_salary && ($job->salary_min || $job->salary_max)): ?>
                    <span class="font-semibold text-green-600"><?php echo e($job->getFormattedSalary()); ?></span>
                <?php else: ?>
                    <span class="text-gray-500 italic">Salary not disclosed</span>
                <?php endif; ?>
            </span>
        </div>
    </div>

    <!-- Description Preview -->
    <p class="text-sm text-gray-600 line-clamp-2 mb-4 leading-relaxed">
        <?php echo e($job->description); ?>

    </p>

    <!-- Footer -->
    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <span class="text-xs text-gray-500">
            📅 <?php echo e($job->published_at->diffForHumans()); ?>

        </span>
    </div>
</div>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/components/cards/job-card.blade.php ENDPATH**/ ?>