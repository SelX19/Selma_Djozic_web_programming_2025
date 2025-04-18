<?php

/**
 * @OA\Get(
 *     path="/blog/{id}",
 *     tags={"blogs"},
 *     summary="Get blog details by ID and type",
 *     description="Returns specific data (blog's content) or full blog info based on the query parameter 'type'.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the blog's article",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Specify what info to return: a blog's 'content' or if omitted, full blog's info is returned.",
 *         @OA\Schema(type="string", enum={"content"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog's information depending on the query parameter"
 *     )
 * )
 */

// retrieval routes for id as parameter:
Flight::route('GET /blog/@id', function ($id) {
    $type = Flight::request()->query['type'];
    if ($type == 'content') {
        Flight::json(Flight::BlogService()->getContent($id)); // get article's content by providing its unique id (if content is provided as query parameter)
    } else {
        Flight::json(Flight::BlogService()->getBlogById($id)); // else, if no query parameters are specified, search for an article (all its data - associative json array) by its id
    }
});

/**
 * @OA\Get(
 *     path="/blog/{author_name}",
 *     tags={"blogs"},
 *     summary="Get blog details by the author name provided",
 *     description="Returns all blog's data based on the query parameter 'author_name'.",
 *     @OA\Parameter(
 *         name="author_name",
 *         in="path",
 *         required=true,
 *         description="The blog's author name",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog information depending on the query parameter"
 *     )
 * )
 */

// retrieve blog's (article's) content by providing author's name as parameter
Flight::route('GET /blog/@author_name', function ($author_name) {
    Flight::json(Flight::BlogService()->getContentByAuthor($author_name));
});

/**
 * @OA\Post(
 *     path="/blog",
 *     tags={"blogs"},
 *     summary="Add a new blog",
 *     description="Creates a new blog(article) using the provided data.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"content", "user_name", "user_rating", "created_at", "blog_id", "user_id"},
 *             @OA\Property(property="created_at", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="content", type="string", example="Why is balanced and healthy nutrition important?"),
 *             @OA\Property(property="user_rating", type="integer", example=5),
 *             @OA\Property(property="user_name", type="string", example="Ana Vilic"),
 *             @OA\Property(property="blog_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog article successfully added"
 *     )
 * )
 */

// add a blog article with data inserted by user
Flight::route('POST /blog', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::BlogService()->addArticle($data));
});

/**
 * @OA\Put(
 *     path="/blog/{id}",
 *     tags={"blogs"},
 *     summary="Update a blog by ID",
 *     description="Updates the blog details using the provided data.",
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
 *             @OA\Property(property="created_at", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="content", type="string", example="Why is balanced and healthy nutrition important?"),
 *             @OA\Property(property="user_rating", type="integer", example=5),
 *             @OA\Property(property="user_name", type="string", example="Ana Vilic")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog article successfully updated"
 *     )
 * )
 */

// update blog article with specific id with data inserted by user
Flight::route('PUT /blog/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::BlogService()->updateBlog($id, $data));
});

/**
 * @OA\Delete(
 *     path="/blog/{id}",
 *     tags={"blogs"},
 *     summary="Delete a blog by ID",
 *     description="Deletes a blog with the given ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog successfully deleted"
 *     )
 * )
 */

//delete a blog article at specific id
Flight::route('DELETE /blog/@id', function ($id) {
    Flight::json(Flight::BlogService()->deleteArticle($id));
});


?>