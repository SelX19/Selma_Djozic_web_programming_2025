<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
Flight::group('/auth', function () {
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user.",
     *     description="Add a new user to the database.",
     *     tags={"auth"},
     *     security={
     *         {"ApiKey": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Add new user",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"password", "email"},
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="some_password",
     *                     description="User password"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="demo@gmail.com",
     *                     description="User email"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User has been added."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing required fields."
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Email already registered."
     *     )
     * )
     */
    Flight::route("POST /register", function () {
        $data = Flight::request()->data->getData();


        $response = Flight::auth_service()->register($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User registered successfully',
                'data' => $response['data']
            ]);
        } else {
            switch ($response['error_code'] ?? '') {
                case 'EMAIL_EXISTS':
                    Flight::halt(409, json_encode(['error' => 'Email already registered']));
                    break;
                case 'MISSING_FIELDS':
                    Flight::halt(400, json_encode(['error' => 'Missing required fields']));
                    break;
                default:
                    Flight::halt(500, json_encode(['error' => $response['error']]));
            }
        }
    });
    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system using email and password",
     *      @OA\Response(
     *           response=200,
     *           description="Student data and JWT"
     *      ),
     *      @OA\RequestBody(
     *          description="Credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="demo@gmail.com", description="Student email address"),
     *              @OA\Property(property="password", type="string", example="some_password", description="Student password")
     *          )
     *      ),
     *      @OA\Response(
     *         response=401,
     *         description="Bad/Invalid data entered."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing required fields."
     *     )
     * )
     */
    Flight::route('POST /login', function () {
        try {

            $data = Flight::request()->data->getData();


            $response = Flight::auth_service()->login($data);

            if ($response['success']) {
                Flight::json([
                    'message' => 'User logged in successfully',
                    'data' => $response['data']
                ]);
            } else {
                switch ($response['error_code'] ?? '') {
                    case 'INVALID_CREDENTIALS':
                        Flight::halt(401, json_encode(['error' => 'Invalid email or password']));
                        break;
                    case 'MISSING_FIELDS':
                        Flight::halt(400, json_encode(['error' => 'Missing required fields']));
                        break;
                    default:
                        Flight::halt(500, json_encode(['error' => $response['error']]));
                }
            }
        } catch (Exception $e) {
            Flight::json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    });
});
?>