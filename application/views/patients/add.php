<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg overflow-y-auto">

        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-left">Add Patient</h2>

        <?php echo form_open_multipart('patient/add', ['class' => 'space-y-4']); ?>

        <!-- Firstname -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Firstname:</label>
            <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('firstname') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('firstname')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('firstname'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Middlename -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Middlename:</label>
            <input type="text" name="middlename" value="<?php echo set_value('middlename'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('middlename') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('middlename')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('middlename'); ?></p>
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

        <!-- Address -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Address:</label>
            <input type="text" name="address" value="<?php echo set_value('address'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('address') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('address')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('address'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Birthdate -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Birthdate:</label>
            <input type="date" name="birthdate" value="<?php echo set_value('birthdate'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('birthdate') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('birthdate')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('birthdate'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Sex -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Sex:</label>
            <select name="sex"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('sex') ? 'border-red-500' : ''; ?>">
                <option value="">Select Sex</option>
                <option value="Male" <?= set_select('sex', 'Male'); ?>>Male</option>
                <option value="Female" <?= set_select('sex', 'Female'); ?>>Female</option>
            </select>
            <?php if (form_error('sex')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('sex'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Email:</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('email') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('email')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('email'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Phone -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Phone:</label>
            <input type="text" name="phone" value="<?php echo set_value('phone'); ?>"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('phone') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('phone')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('phone'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Upload Image -->
        <div class="flex flex-col">
            <label class="text-sm font-medium text-gray-600">Upload Image:</label>
            <input type="file" name="profile_image"
                class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo form_error('profile_image') ? 'border-red-500' : ''; ?>">
            <?php if (form_error('profile_image')): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo form_error('profile_image'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Buttons -->
        <div class="flex justify-start space-x-3 mt-4">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Submit
            </button>
            <button type="button" onclick="window.location.href='<?= site_url('patient/index') ?>'"
                class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">
                Go Back
            </button>
        </div>

        <?php echo form_close(); ?>

    </div>

    <!-- Flash Messages for SweetAlert -->
    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= $this->session->flashdata('success'); ?>',
                timer: 2000
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $this->session->flashdata('error'); ?>',
                timer: 2000
            });
        </script>
    <?php endif; ?>

</body>
</html>

