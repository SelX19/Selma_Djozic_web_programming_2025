<?php

/**
 * @OA\Get(
 *     path="/trainer/{id}",
 *     tags={"trainers"},
 *     summary="Get trainer details by ID and type",
 *     description="Returns specific trainer's data (specialization, bio, experience, rating) or full trainer info based on the query parameter 'type'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the trainer",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Specify what info to return: 'specialization', 'bio', 'experience', or 'rating'. If omitted, full trainer info is returned.",
 *         @OA\Schema(type="string", enum={"specialization", "bio", "experience", "rating"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer information depending on the query parameter"
 *     )
 * )
 */

// Get a specialization/rating etc. for trainer - depending on what is defined in query paramters, or if nothing is specified as query parameter- find specific trainer by ID

Flight::route('GET /trainer/@id', function ($id) {
    $type = Flight::request()->query['type']; // e.g. /trainer/5?type=specialization

    if ($type === 'specialization') {
        Flight::json(Flight::TrainerService()->getSpecialization($id)); //get specialization for trainer with specified id
    } else if ($type === 'bio') {
        Flight::json(Flight::TrainerService()->getBio($id)); //get bio for trainer with specified id
    } else if ($type === 'experience') {
        Flight::json(Flight::TrainerService()->getExperience($id)); //get experience for trainer with specified id
    } else if ($type === 'rating') {
        Flight::json(Flight::TrainerService()->getRating($id)); //get rating for trainer with specified id
    } else { //otherwise, if no query parameter specified (just written in url: /trainer/5 - call function getTrainerById(@) - to retrieve all data about trainer with specified id as parameter)
        Flight::json(Flight::TrainerService()->getTrainerById($id));
    }
});

// other get methods - getBy.. - with different parameters (no need for query parameters since there is one method with each specific parameter)

/**
 * @OA\Get(
 *     path="/trainer/{specialization}",
 *     tags={"trainers"},
 *     summary="Get trainer details by its specialization",
 *     description="Returns all trainer data based on the query parameter 'specialization'.",
 *     @OA\Parameter(
 *         name="specialization",
 *         in="path",
 *         required=true,
 *         description="The specialization of the trainer",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer information depending on the query parameter"
 *     )
 * )
 */

// Get a specific trainer by specialization
Flight::route('GET /trainer/@specialization', function ($specialization) {
    Flight::json(Flight::TrainerService()->getBySpecialization($specialization));
});

/**
 * @OA\Get(
 *     path="/trainer/{experience}",
 *     tags={"trainers"},
 *     summary="Get trainer details by its experience",
 *     description="Returns all trainer data based on the query parameter 'experience'.",
 *     @OA\Parameter(
 *         name="experience",
 *         in="path",
 *         required=true,
 *         description="The experience of the trainer",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer information depending on the query parameter"
 *     )
 * )
 */

// Get a specific trainer by experience
Flight::route('GET /trainer/@experience', function ($experience) {
    Flight::json(Flight::TrainerService()->getByExperience($experience));
});

/**
 * @OA\Get(
 *     path="/trainer/{rating}",
 *     tags={"trainers"},
 *     summary="Get trainer details by its rating",
 *     description="Returns all trainer data based on the query parameter 'rating'.",
 *     @OA\Parameter(
 *         name="rating",
 *         in="path",
 *         required=true,
 *         description="The rating of the trainer",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer information depending on the query parameter"
 *     )
 * )
 */

// Get a specific trainer by rating
Flight::route('GET /trainer/@rating', function ($rating) {
    Flight::json(Flight::TrainerService()->getByRating($rating));
});

/**
 * @OA\Post(
 *     path="/trainer",
 *     tags={"trainers"},
 *     summary="Add a new trainer",
 *     description="Creates a new trainer using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"specialization", "bio", "experience", "rating", "trainer_id", "user_id"},
 *             @OA\Property(property="specialization", type="string", format="date", example="Yoga"),
 *             @OA\Property(property="bio", type="string", example="Experienced yoga trainer"),
 *             @OA\Property(property="experience", type="integer", example=10),
 *             @OA\Property(property="rating", type="integer", example=3),
 *             @OA\Property(property="trainer_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer successfully added"
 *     )
 * )
 */

// Add a new trainer
Flight::route('POST /trainer', function () {
    $data = Flight::request()->data->getData(); //data entered by user
    Flight::json(Flight::TrainerService()->addTrainer($data));
});

/**
 * @OA\Put(
 *     path="/trainer/{id}",
 *     tags={"trainers"},
 *     summary="Update a trainer by ID",
 *     description="Updates the trainer details using the provided data.",
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
 *             @OA\Property(property="specialization", type="string", format="date", example="Yoga"),
 *             @OA\Property(property="bio", type="string", example="Experienced yoga trainer"),
 *             @OA\Property(property="experience", type="integer", example=10),
 *             @OA\Property(property="rating", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer data successfully updated"
 *     )
 * )
 */

// Update trainer with specific ID
Flight::route('PUT /trainer/@id', function ($id) {
    $data = Flight::request()->data->getData(); //data entered by user at the page
    Flight::json(Flight::TrainerService()->updateTrainer($id, $data)); // at the id passed in as parameter, with data entered/submitted by user
});

/**
 * @OA\Delete(
 *     path="/trainer/{id}",
 *     tags={"trainers"},
 *     summary="Delete a trainer by ID",
 *     description="Deletes a trainer with the given ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Trainer successfully deleted"
 *     )
 * )
 */

// Delete trainer with specific ID
Flight::route('DELETE /trainer/@id', function ($id) {
    Flight::json(Flight::TrainerService()->deleteTrainer($id));
});

?>