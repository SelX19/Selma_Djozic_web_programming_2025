<?php

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get all users",
 *     description="Returns a list of all users in the system.",
 *     @OA\Response(
 *         response=200,
 *         description="List of users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
Flight::route('GET /users', function () {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // Only admins should retrieve all users
    Flight::json(Flight::UserService()->getAll());
});

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get user details by ID and type",
 *     description="Returns specific data (phone, role) or full user info based on the query parameter 'type'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the user",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Specify what info to return: 'phone', 'role'. If omitted, full user info is returned.",
 *         @OA\Schema(type="string", enum={"phone", "role"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User information depending on the query parameter"
 *     )
 * )
 */

// retrieval methods with the same parameter (@id) - have to specify query parameters to know which method to call, otherwise, if no query parameters are specified, getByid($id) will be called by default
Flight::route('GET /user/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    $type = Flight::request()->query['type']; // e.g. /user/3?type=phone -> getPhone($id) - for user with specified id

    if ($type === 'phone') {
        Flight::json(Flight::UserService()->getPhone($id)); //get phone number for user with specified id
    } else if ($type === 'role') {
        Flight::json(Flight::UserService()->getBio($id)); //get role for user with specified id (P.S: since trainer is a user, it could be regular user role or trainer or even admin - later to be implemented)
    } else { //otherwise, if no query parameter specified (just written in url: /user/5 - call function getById(5) - to retrieve all data about user with specified id as parameter)
        Flight::json(Flight::UserService()->getById($id));
    }
});

/**
 * @OA\Get(
 *     path="/users/profile",
 *     summary="Get logged-in user's profile",
 *     tags={"Users"},
 *     security={{"ApiKeyAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="User profile retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="email", type="string", example="user@example.com"),
 *                 @OA\Property(property="role", type="string", example="user")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized - invalid or missing token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Missing or malformed Authorization header")
 *         )
 *     )
 * )
 */


Flight::route('GET /users/profile', function () {
    $user = Flight::get('user'); // This is set in verifyToken()
    Flight::json([
        'status' => 'success',
        'data' => $user
    ]);
});


/**
 * @OA\Get(
 *     path="/user/role/{role}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get user details by its role",
 *     description="Returns all user data based on the query parameter 'role'.",
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         description="The role (trainer/regular user) of the user",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User information depending on the query parameter"
 *     )
 * )
 */

// Get a specific user by role
Flight::route('GET /user/role/@role', function ($role) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::UserService()->getByRole($role));
});

/**
 * @OA\Get(
 *     path="/user/first_name/{first_name}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get user details by its first name",
 *     description="Returns all user data based on the query parameter 'first_name'.",
 *     @OA\Parameter(
 *         name="first_name",
 *         in="path",
 *         required=true,
 *         description="The first name of the user",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User information depending on the query parameter"
 *     )
 * )
 */

// Get a specific user by first name
Flight::route('GET /user/first_name/@first_name', function ($first_name) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::UserService()->getByFirstName($first_name));
});

/**
 * @OA\Get(
 *     path="/user/last_name/{last_name}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get user details by its last name",
 *     description="Returns all user data based on the query parameter 'last_name'.",
 *     @OA\Parameter(
 *         name="last_name",
 *         in="path",
 *         required=true,
 *         description="The last name of the user",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User information depending on the query parameter"
 *     )
 * )
 */

// Get a specific user by last name
Flight::route('GET /user/last_name/@last_name', function ($last_name) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::UserService()->getByLastName($last_name));
});

/**
 * @OA\Get(
 *     path="/user/email/{email}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get user details by its email",
 *     description="Returns all user data based on the query parameter 'email'.",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="The email of the user",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User information depending on the query parameter"
 *     )
 * )
 */

// Get a specific user by email
Flight::route('GET /user/email/@email', function ($email) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::UserService()->getByEmail($email));
});

/**
 * @OA\Post(
 *     path="/user",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Add a new user",
 *     description="Creates a new user using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"first_name", "last_name", "email", "password", "phone", "role"},
 *             @OA\Property(property="first_name", type="string", example="Selma"),
 *             @OA\Property(property="last_name", type="string", example="Djozic"),
 *             @OA\Property(property="email", type="string", example="selma.dozic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", type="string", example="Bey*567"),
 *             @OA\Property(property="phone", type="string", example="061-361-107"),
 *             @OA\Property(property="role", type="string", example="user(regular)"),
 *             @OA\Property(property="trainer_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User successfully added"
 *     )
 * )
 */

// Add a new user
Flight::route('POST /user', function () {
    Flight::auth_middleware()->authorizeRole('admin'); // only admin can add user to the system/db
    $data = Flight::request()->data->getData(); //data entered by user
    Flight::json(Flight::UserService()->addUser($data));
});

/**
 * @OA\Put(
 *     path="/user/{id}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Update a user by ID",
 *     description="Updates the user details using the provided data.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="first_name", type="string", example="Selma"),
 *             @OA\Property(property="last_name", type="string", example="Djozic"),
 *             @OA\Property(property="email", type="string", example="selma.dozic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", type="string", example="Bey*567"),
 *             @OA\Property(property="phone", type="string", example="061-361-107"),
 *             @OA\Property(property="role", type="string", example="user(regular)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User data successfully updated"
 *     )
 * )
 */

// Update user by ID (with specific ID)
Flight::route('PUT /user/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole('admin'); // only admin can update data about user with the specified id
    $data = Flight::request()->data->getData(); //data entered by user at the page
    Flight::json(Flight::UserService()->updateUser($id, $data)); // at the id passed in as parameter, with data entered/submitted by user
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"users"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Delete a user by ID",
 *     description="Deletes a user with the given ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User successfully deleted"
 *     )
 * )
 */

// Delete restaurant by ID (with specific ID)
Flight::route('DELETE /user/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole('admin'); // only admin can delete data about user with the specified id
    Flight::json(Flight::UserService()->deleteUser($id));
});

?>