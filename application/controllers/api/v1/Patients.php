<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Patients extends CI_Controller 
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Patient_model');
    }

    /**
         * @OA\GET(
         * path="/api/v1/patients",
         * summary="Get all patients",
         * tags={"Patients"},
         * @OA\Response(
         * response=200,
         * description="Patients retrieved successfully",
         * @OA\JsonContent(
         * type="array",
         * @OA\Items(ref="#/components/schemas/Patient")
         * )
         * ),
         * @OA\Response(
         * response=404,
         * description="No patients found"
         * ),
         * security={{"basicAuth": {}}}
         * )
         *
    */
    public function all() 
    {

        $patients = $this->Patient_model->get_all_patients();

        if (empty($patients)) {
            
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 404,
                    'message' => 'No patients found'
                ]));
            
        }
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 200,
                    'message' => 'Patients retrieved successfully',
                    'data' => $patients
                ]));
    }

    /**
     * @OA\Post(
     *   tags={"Patients"}, 
     *   path="/api/v1/patients", 
     *   security={{"BasicAuth": {}}},
     *   summary="Create a new patient", 
     *   @OA\RequestBody(  
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *               @OA\Property(
     *                  property="id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="firstname",
     *                  type="string",
     *                  example="John"
     *              ),
     *              @OA\Property(
     *                  property="middlename",
     *                  type="string",
     *                  example="Michael",
     *                  nullable=true
     *              ),
     *              @OA\Property(
     *                  property="lastname",
     *                  type="string",
     *                  example="Doe"
     *              ),
     *              @OA\Property(
     *                  property="address",
     *                  type="string",
     *                  example="123 Main St",
     *                  nullable=true
     *              ),
     *              @OA\Property(
     *                  property="birthdate",
     *                  type="string",
     *                  format="date",
     *                  example="1990-01-01"
     *              ),
     *              @OA\Property(
     *                  property="sex",
     *                  type="string",
     *                  example="Male",
     *                  nullable=true
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email",
     *                  example="john.doe@example.com",
     *                  nullable=true
     *              ),
     *              @OA\Property(
     *                  property="phone",
     *                  type="string",
     *                  example="123-456-7890",
     *                  nullable=true
     *              ),
     *          )
     *      )
     * ), 
     *   @OA\Response( 
     *     response=201, 
     *     description="Patient created", 
     *     @OA\JsonContent(ref="#/components/schemas/Patient") 
     *   ), 
     *   @OA\Response(response=400, description="Invalid request") 
     * )
    */
 
    public function create() 
    {
        // Basic Authentication Check
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Authentication Required.']);
            exit;
        }

        // Determine the request content type
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            // Handle JSON request
            $postData = json_decode(file_get_contents('php://input'), true);
        } elseif (strpos($contentType, 'multipart/form-data') !== false) {
            // Handle multipart form data
            $postData = $_POST;
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Unsupported content type']);
            exit;
        }

        $patientData = [
            'firstname'     => $postData['firstname'],
            'middlename'    => $postData['middlename'] ?? null,
            'lastname'      => $postData['lastname'],
            'address'       => $postData['address'] ?? null,
            'birthdate'     => $postData['birthdate'],
            'sex'           => $postData['sex'] ?? null,
            'email'         => $postData['email'] ?? null,
            'phone'         => $postData['phone'] ?? null,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        try {
            $insertStatus = $this->Patient_model->insert_patient($patientData);

            if ($insertStatus) {
                $patientData['id'] = $this->db->insert_id();
                
                header('Content-Type: application/json');
                http_response_code(201);
                echo json_encode(['status' => 'success', 'data' => $patientData]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create patient.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }


    /**
     * @OA\Get(
     *   tags={"Patients"},
     *   path="/api/v1/patients/{id}",
     *   security={{"BasicAuth": {}}},
     *   summary="Get patient by ID",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Patient ID",
     *      required=true,
     *      @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Patient retrieved",
     *   @OA\JsonContent(ref="#/components/schemas/Patient")),
     *   @OA\Response(response=400, description="Invalid request"),
     * )
    */

    public function read($id)
    {
        if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Authentication Required.']);
            exit;
        }

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid patient ID.']);
            exit;
        }

        $patient = $this->Patient_model->get_patient_by_id($id);

        if ($patient) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $patient]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Patient not found.']);
        }
    }

/**
 * @OA\Delete(
 *   tags={"Patients"},
 *   path="/api/v1/patients/{id}",
 *   security={{"BasicAuth": {}}},
 *   summary="Soft delete a patient by ID",
 *   @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="Patient ID",
 *      required=true,
 *      @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Patient deleted successfully"),
 *   @OA\Response(response=400, description="Invalid request"),
 * )
*/

 public function delete($id)
{
    if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Authentication Required.']);
        exit;
    }

    if (!is_numeric($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid patient ID.']);
        exit;
    }

    $patient = $this->Patient_model->get_patient_by_id($id);
    if (!$patient) {
        http_response_code(404);
        echo json_encode(['error' => 'Patient not found.']);
        exit;
    }

    if ($this->Patient_model->delete_patient($id)) {
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Patient deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete patient.']);
    }
}



    /**
     * @OA\Schema(
     * schema="Patient",
     * title="Patient",
     * description="Patient model",
     * @OA\Property(property="id", type="integer", description="Patient ID", example=1),
     * @OA\Property(property="firstname", type="string", description="First Name", example="John"),
     * @OA\Property(property="middlename", type="string", description="Middle Name", example="M"),
     * @OA\Property(property="lastname", type="string", description="Last Name", example="Doe"),
     * @OA\Property(property="email", type="string", description="Email Address", example="john.doe@example.com"),
     * @OA\Property(property="phone", type="string", description="Phone Number", example="+639123456789"),
     * @OA\Property(property="address", type="string", description="Address", example="123 Main St, City, Country"),
     * @OA\Property(property="birthdate", type="string", format="date", description="Birth Date", example="1990-01-01"),
     * @OA\Property(property="sex", type="string", description="Gender", example="Male"),
     * @OA\Property(property="profile_image", type="string", description="Profile Image", example="profile.jpg")
     * )
     */
}


?>