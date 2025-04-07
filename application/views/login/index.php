<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Login Form Container -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Login</h2>

         <!-- Error Message -->
         <?php if ($this->session->flashdata('error')) : ?>
            <p class="text-red-500 text-sm text-center mb-4"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <!-- Form -->
        <?php echo form_open('login/auth', ['class' => 'space-y-4']); ?>
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email">
                <?php if (form_error('email')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('email'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your password">
                <?php if (form_error('password')): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo form_error('password'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Login
            </button>
        <?php echo form_close(); ?>

        <!-- Additional Links -->
        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account? 
            <a href="<?= base_url('register/index') ?>" class="text-blue-500 hover:underline">Register</a>
        </p>

    </div>

</body>
</html>
