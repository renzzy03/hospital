<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Registration Form Container -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Register</h2>

        <!-- Success Message -->
        <?php if ($this->session->flashdata('success')): ?>
            <p class="text-green-500 mb-4"><?php echo $this->session->flashdata('success'); ?></p>
        <?php endif; ?>
        
        <!-- Form -->
        <?php echo form_open('register/add', ['class' => 'space-y-4']); ?>

            <!-- Firstname -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600">Firstname:</label>
                <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('firstname') ? 'border-red-500' : ''; ?>">
                <?php if (form_error('firstname')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('firstname'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Lastname -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600">Lastname:</label>
                <input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('lastname') ? 'border-red-500' : ''; ?>">
                <?php if (form_error('lastname')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('lastname'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600">Email:</label>
                <input type="email" name="email" value="<?php echo set_value('email'); ?>"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('email') ? 'border-red-500' : ''; ?>">
                <?php if (form_error('email')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('email'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600">Password:</label>
                <input type="password" name="password"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('password') ? 'border-red-500' : ''; ?>">
                <?php if (form_error('password')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('password'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600">Confirm Password:</label>
                <input type="password" name="confirm_password"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('confirm_password') ? 'border-red-500' : ''; ?>">
                <?php if (form_error('confirm_password')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('confirm_password'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                Register
            </button>

        <?php echo form_close(); ?>


        <!-- Additional Links -->
        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account? 
            <a href="<?= base_url('login') ?>" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
