<?php

/**
 * @OA\Get(
 *     path="/workout/{workout_name}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get workout video's URL by its name",
 *     description="Returns workout video's URL based on the query parameter 'workout_name'.",
 *     @OA\Parameter(
 *         name="workout_name",
 *         in="path",
 *         required=true,
 *         description="The name of the workout",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout video depending on the query parameter"
 *     )
 * )
 */

// get videoURL for the given workout, by searching by provided workout name
Flight::route('GET /workout/@workout_name', function ($workout_name) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::WorkoutService()->getVideoURL($workout_name));
});

/**
 * @OA\Get(
 *     path="/workout/{difficulty}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get workout details by its specified difficulty",
 *     description="Returns all workout data based on the query parameter 'difficulty'.",
 *     @OA\Parameter(
 *         name="difficulty",
 *         in="path",
 *         required=true,
 *         description="The difficulty level of the workout",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout information depending on the query parameter"
 *     )
 * )
 */

// get workout by provided difficulty (level -> e.g. beginner/medium/advanced)
Flight::route('GET /workout/@difficulty', function ($difficulty) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::WorkoutService()->getByDifficulty($difficulty));
});

/**
 * @OA\Get(
 *     path="/workout/{duration}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get workout details by its specified duration ",
 *     description="Returns all workout data based on the query parameter 'duration'.",
 *     @OA\Parameter(
 *         name="duration",
 *         in="path",
 *         required=true,
 *         description="Duration of the workout",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout information depending on the query parameter"
 *     )
 * )
 */

// get workout by provided duration 
Flight::route('GET /workout/@duration', function ($duration) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    Flight::json(Flight::WorkoutService()->getByDuration($duration));
});

/**
 * @OA\Get(
 *     path="/workout/{id}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Get workout details by ID and type",
 *     description="Returns specific data (description or duration of a workout) or full workout info based on the query parameter 'type'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the workout",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Specify what info to return: 'description, 'duration'. If omitted, full workout info is returned.",
 *         @OA\Schema(type="string", enum={"duration", "description"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout information depending on the query parameter"
 *     )
 * )
 */

// retrieval routes for id as parameter, and different query parameters:
Flight::route('GET /workout/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer', 'user']); // all roles shall have access
    $type = Flight::request()->query['type'];
    if ($type == 'description') {
        Flight::json(Flight::WorkoutService()->getDescription($id)); // get description of a program with specific id
    } else if ($type == 'duration') {
        Flight::json(Flight::WorkoutService()->getDuration($id)); // get duration of a program with specific id
    } else {
        Flight::json(Flight::WorkoutService()->getWorkoutById($id)); // else, if no query parameters are specified, search for a workout(all its data - associative json array) by its id
    }
});

/**
 * @OA\Post(
 *     path="/workout",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Add a new workout",
 *     description="Creates a new workout using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "video_url", "description", "duration", "difficulty", "workout_id", "program_id"},
 *            @OA\Property(property="name", type="string", example="Upper Body Workout"),
 *             @OA\Property(property="video_url", type="string", example="https://youtube/workoutupperbody.com"),
 *             @OA\Property(property="description", type="string", example="This workout hrows your back muscles."),
 *             @OA\Property(property="duration", type="integer", example=20),
 *             @OA\Property(property="difficulty", type="string", example="Beginner"),
 *             @OA\Property(property="workout_id", type="integer", example=1),
 *             @OA\Property(property="program_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout successfully added"
 *     )
 * )
 */

// add a workout with data inserted by user
Flight::route('POST /workout', function () {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer']); //Only trainers and admin can add a workout, regular users cannot
    $data = Flight::request()->data->getData();
    Flight::json(Flight::WorkoutService()->addWorkout($data));
});

/**
 * @OA\Put(
 *     path="/workout/{id}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Update a workout by ID",
 *     description="Updates workout details using the provided data.",
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
 *             @OA\Property(property="name", type="string", example="Upper Body Workout"),
 *             @OA\Property(property="video_url", type="string", example="https://youtube/workoutupperbody.com"),
 *             @OA\Property(property="description", type="string", example="This workout hrows your back muscles."),
 *             @OA\Property(property="duration", type="integer", example=20),
 *             @OA\Property(property="difficulty", type="string", example="Beginner")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout successfully updated"
 *     )
 * )
 */

// update a workout at specific id with data inserted by user
Flight::route('PUT /workout/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles(['admin', 'trainer']); //Only trainers and admin can update a workout, regular users cannot
    $data = Flight::request()->data->getData();
    Flight::json(Flight::WorkoutService()->updateWorkout($id, $data));
});

/**
 * @OA\Delete(
 *     path="/workout/{id}",
 *     tags={"workouts"},
 *     security={{"ApiKeyAuth": {}}},
 *     summary="Delete a workout by ID",
 *     description="Deletes a workout with the given ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout successfully deleted"
 *     )
 * )
 */

//delete a workout at specific id
Flight::route('DELETE /workout/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole('admin'); //Since this is a sensitive route, affecting the page's content, only admin can delete a workout based on trainer's request, trainers or regular users cannot
    Flight::json(Flight::WorkoutService()->deleteWorkout($id));
});

?>