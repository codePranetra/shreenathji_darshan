<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <title>Shreenath Ji Darshan Booking Portal</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <meta name="description" content="Book your Shreenath Ji Darshan online. Nathdwara Darshan Booking, Shree Ji Darshan, Online Mandir Darshan with Pichwai art inspired packages.">
        <meta name="keywords" content="Shree Ji Darshan, Shreenath Ji Darshan, Nathdwara Darshan Booking, Online Mandir Darshan, Shreenath Ji Pichwai Booking">
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('images/shrinathji-or-lord-krishna-as-pichwai-folk-painting-vector (1).jpg')); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Noto+Serif+Devanagari:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


        <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

        <?php echo $__env->yieldContent('css'); ?>

        


        @livewireStyles <!-- Livewire styles -->

        <!-- Meta Tags (conditionally included) -->
        <?php if (! empty(trim($__env->yieldContent('meta-tags')))): ?>
            <?php echo $__env->yieldContent('meta-tags'); ?>
        <?php endif; ?>
        <style>

        </style>
    </head>
    <body>
        <!-- Navigation -->
        <?php echo $__env->make('layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Main Content Section -->
        <main>
            <?php echo $__env->yieldContent('content'); ?> <!-- Content will be injected here -->
        </main>

        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Scripts -->
        @livewireScripts <!-- Livewire scripts -->

        <script src="<?php echo e(asset('js/main.js')); ?>"></script>
        <?php echo $__env->yieldContent('js'); ?> <!-- Additional JS scripts can be added here -->
    </body>
</html><?php /**PATH D:\shreenathji latest project\shreenathji_darshan\resources\views/layouts/app.blade.php ENDPATH**/ ?>