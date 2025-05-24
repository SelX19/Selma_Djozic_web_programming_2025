<?php

/**
 * @OA\Get(
 *     path="/program/{id}",
 *     tags={"programs"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get program details by its id",
 *     description="Returns all program data based on the query parameter 'id'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The id of the program",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Program information depending on the query parameter"
 *     )
 * )
 */

//retrieve program by id
Flight::route('GET /program/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::ProgramService()->getProgramById($id));
});

/**
 * @OA\Get(
 *     path="/program/{name}",
 *     tags={"programs"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get program description by its name",
 *     description="Returns program's description based on the query parameter 'name'.",
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         description="The name of the program",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Program information depending on the query parameter"
 *     )
 * )
 */

// retrieve a program's description, by searching for it by program's name
Flight::route('GET /program/@name', function ($name) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::ProgramService()->getDescription($name));
});

/**
 * @OA\Post(
 *     path="/program",
 *     tags={"programs"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Add a new program",
 *     description="Creates a new program using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"enrollment_date", "program_id", "user_id"},
 *             @OA\Property(property="enrollment_date", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="program_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Program successfully added"
 *     )
 * )
 */

// add a program 
Flight::route('POST /program', function () {
    Flight::auth_middleware()->authorizeRole('admin');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::ProgramService()->addProgram($data)); //only admin (if later added) shall be able to add program, as well as to update it, and delete it. User and trainer shall not have these privileges
});

/**
 * @OA\Put(
 *     path="/program/{id}",
 *     tags={"programs"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Update a program by ID",
 *     description="Updates the program details using the provided data.",
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
 *             @OA\Property(property="enrollment_date", type="string", format="date", example="2025-04-16")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Program data successfully updated"
 *     )
 * )
 */

// update the program
Flight::route('PUT /program/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole('admin');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::ProgramService()->updateProgram($id, $data));
});

/**
 * @OA\Delete(
 *     path="/program/{id}",
 *     tags={"programs"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Delete a program by ID",
 *     description="Deletes a program with the given ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Program successfully deleted"
 *     )
 * )
 */

// delete the program
Flight::route('DELETE /program/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole('admin');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::ProgramService()->deleteProgram($id));
});


?>