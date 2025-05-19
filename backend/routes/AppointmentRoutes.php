<?php

/**
 * @OA\Get(
 *     path="/appointment/{id}",
 *     tags={"appointments"},
 *     summary="Get appointment details by ID and type",
 *     description="Returns specific data (date, time, status) or full appointment info based on the query parameter 'type'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the appointment",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Specify what info to return: 'date', 'time', 'status'. If omitted, full appointment info is returned.",
 *         @OA\Schema(type="string", enum={"date", "time", "status"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment information depending on the query parameter"
 *     )
 * )
 */

// retrieval routes for id as parameter:
Flight::route('GET /appointment/@id', function ($id) {
    // no restriction needed, since all roles shall be able to access appointment's details (e.g. date, and time) by its id
    $type = Flight::request()->query['type'];
    if ($type == 'date') {
        Flight::json(Flight::AppointmentService()->getAppointmentDate($id)); // get appointment's date by providing its unique id (if date is provided as a query parameter)
    } else if ($type == 'time') {
        Flight::json(Flight::AppointmentService()->getAppointmentTime($id)); // get appointment's time by providing its unique id (if time is provided as a query parameter)
    } else if ($type == 'status') {
        Flight::json(Flight::AppointmentService()->getStatus($id)); // get appointment's status by providing its unique id (if status is provided as a query parameter)
    } else {
        Flight::json(Flight::AppointmentService()->getAppointmentById($id)); // otherwise, if no query parameters are specified, search for an appointment (all its data - associative json array) by its id
    }
});

/**
 * @OA\Get(
 *     path="/appointment/{status}",
 *     tags={"appointments"},
 *     summary="Get appointment details by its status",
 *     description="Returns all appointment data based on the query parameter 'status'.",
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         description="The status of the appointment",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment information depending on the query parameter"
 *     )
 * )
 */

// retrieve appointment by its status (e.g. active/cancelled/..)
Flight::route('GET /appointment/@status', function ($status) { //no restriction needed 
    Flight::json(Flight::AppointmentService()->getByStatus($status));
});

/**
 * @OA\Get(
 *     path="/appointment/{time}",
 *     tags={"appointments"},
 *     summary="Get appointment details by the exact time of the appointment",
 *     description="Returns all appointment data based on the query parameter 'time'.",
 *     @OA\Parameter(
 *         name="time",
 *         in="path",
 *         required=true,
 *         description="The time of the appointment in HH:MM format",
 *         @OA\Schema(type="string", format="time")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment information depending on the query parameter"
 *     )
 * )
 */

// retrieve appointment by its time
Flight::route('GET /appointment/@time', function ($time) { //no restriction needed (both user and trainer has access to get/view appointment by time)
    Flight::json(Flight::AppointmentService()->getByAppointmentTime($time));
});

/**
 * @OA\Get(
 *     path="/appointment/{date}",
 *     tags={"appointments"},
 *     summary="Get appointment details by the exact date of the appointment",
 *     description="Returns all appointment data based on the query parameter 'date'.",
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         description="The date of the appointment in the format: YYYY-MM-DD",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment information depending on the query parameter"
 *     )
 * )
 */

// retrieve appointment by its date
Flight::route('GET /appointment/@date', function ($date) {  //no restriction needed 
    Flight::json(Flight::AppointmentService()->getByAppointmentDate($date));
});

/**
 * @OA\Post(
 *     path="/appointment",
 *     tags={"appointments"},
 *     summary="Add a new appointment",
 *     description="Creates a new appointment using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"date", "time", "trainer_id", "user_id"},
 *             @OA\Property(property="date", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="time", type="string", example="14:00"),
 *             @OA\Property(property="status", type="string", example="confirmed"),
 *             @OA\Property(property="trainer_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment successfully added"
 *     )
 * )
 */

// add an appointment with data inserted by user (via calendar)
Flight::route('POST /appointment', function () {
    Flight::auth_middleware()->authorizeRole(Roles::TRAINER); //since appointment is made with specific trainer, I am restricting adding of appointment only to the trainer role, user can only book appointment in the sense of contacting trainer, and then trainer regarding his/her schedule makes an appointment (as in healthcare system with doctors, user/client makes a request, and doctor/someone in hopsital makes an appointment)
    $data = Flight::request()->data->getData();
    Flight::json(Flight::AppointmentService()->addAppointment($data));
});

/**
 * @OA\Put(
 *     path="/appointment/{id}",
 *     tags={"appointments"},
 *     summary="Update an appointment by ID",
 *     description="Updates the appointment details using the provided data.",
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
 *             @OA\Property(property="date", type="string", format="date", example="2025-04-20"),
 *             @OA\Property(property="time", type="string", example="15:30"),
 *             @OA\Property(property="status", type="string", example="confirmed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment successfully updated"
 *     )
 * )
 */

// update the appointment with specific id with data inserted by user
Flight::route('PUT /appointment/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN); //However, since updating or deleting an appointment are sensitive routes, we are restricting those to admin only, to prevent e.g. trainers deleting others' appointments, or updating them (malicious behavior)
    $data = Flight::request()->data->getData();
    Flight::json(Flight::AppointmentService()->updateAppointment($id, $data));
});

/**
 * @OA\Delete(
 *     path="/appointment/{id}",
 *     tags={"appointments"},
 *     summary="Delete an appointment by ID",
 *     description="Deletes the appointment with the given ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment successfully deleted"
 *     )
 * )
 */

// delete the appointment at specific id
Flight::route('DELETE /appointment/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::AppointmentService()->deleteAppointment($id));
});

?>