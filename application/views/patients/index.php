<!DOCTYPE html>
<html>
<head>
    <title>Patients List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"></link>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center p-8">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Patients List</h2>

    <!-- Success Message -->
    <?php if ($this->session->flashdata('success')): ?>
        <p class="text-green-500 mb-4"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <!-- Add New Patient Button -->
    <div class="w-full mb-6 flex justify-between items-center">
        <a href="<?php echo base_url('patient/add'); ?>" 
            class="btn btn-primary">
            + Add New Patient
        </a>
            <!-- Logout Button -->
        <a href="<?php echo base_url('login/index'); ?>" 
            class="btn btn-danger">
            Logout
        </a>
    </div>


    <!-- Patient Table -->
    <div class="overflow-x-auto w-full">
        <table id="patientTable" class="w-full text-sm text-left text-gray-700 border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Firstname</th>
                    <th class="px-4 py-2">Middlename</th>
                    <th class="px-4 py-2">Lastname</th>
                    <th class="px-4 py-2">Birthdate</th>
                    <th class="px-4 py-2">Sex</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Profile Image</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2"><?php echo $patient['id']; ?></td>
                    <td class="px-4 py-2"><?php echo $patient['firstname']; ?></td>
                    <td class="px-4 py-2"><?php echo $patient['middlename']; ?></td>
                    <td class="px-4 py-2"><?php echo $patient['lastname']; ?></td>
                    <td class="px-4 py-2"><?php echo date('F d, Y', strtotime($patient['birthdate'])); ?></td>
                    <td class="px-4 py-2"><?php echo $patient['sex']; ?></td>
                    <td class="px-4 py-2"><?php echo $patient['email']; ?></td>
                    <td class="px-4 py-2"><?php echo $patient['phone']; ?></td>
                    <td class="px-4 py-2">
                        <?php if (!empty($patient['profile_image'])): ?>
                            <img src="<?php echo base_url('uploads/' . $patient['profile_image']); ?>" 
                                alt="Profile Image" class="w-12 h-12 rounded-full object-cover shadow-md">
                        <?php else: ?>
                            <span class="text-gray-500 italic">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="viewPatient(<?= $patient['id']?> ); ">
                        View
                        </button>
                        |
                        <a href="<?php echo base_url('patient/update/'.$patient['id']); ?>" 
                           class="text-blue-500 hover:underline"> <i class="fa fa-edit"></i> Edit</a>
                        |
                        <a href="<?php echo base_url('patient/delete/'.$patient['id']); ?>" 
                           onclick="return confirm('Are you sure?');"
                           class="text-red-500 hover:underline"> <i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
        

    <!-- Patient Modal -->                  

    <div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                 
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-start">
                        <!-- Profile Image -->
                        <div class="me-3">
                            <img id="patientProfile" alt="Profile Image" class="rounded img-thumbnail" style="width: 150px; height: 150px; object-full: cover;">
                        </div>

                        <!-- Patient Details -->
                        <div>
                            <p><strong>Name:</strong> <span id="patientName"></span></p>
                            <p><strong>Email:</strong> <span id="patientEmail"></span></p>
                            <p><strong>Phone:</strong> <span id="patientPhone"></span></p>
                            <p><strong>Address:</strong> <span id="patientAddress"></span></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>              
            </div>             
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <!-- DataTable Initialization -->
    <script >
        $(document).ready(function() {
            $('#patientTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5
            });
        });

        function viewPatient(id){
            $.ajax({
               url:"<?= base_url('patient/get_patient/') ?>" + id,
               type: "GET",
               dataType: "JSON",
               success: function(response){
                    if(response){
                        $('#patientProfile').attr('src', response.profile_image);
                        $('#patientName').text(response.name);
                        $('#patientEmail').text(response.email);
                        $('#patientPhone').text(response.phone);
                        $('#patientAddress').text(response.address);
                        $('#patientModal').modal("show");
                    }
               },
               error: function() {
                alert("Failed to fetch patient details");
               }
            });
        }
        
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('patient/delete/') ?>" + id;
                }
            });
        }
    </script>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= $this->session->flashdata('success'); ?>',
                timer: 3000
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $this->session->flashdata('error'); ?>',
                timer: 3000
            });
        </script>
    <?php endif; ?>

</body>
</html>