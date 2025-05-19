<?php

use PHPUnit\Framework\TestCase;

//testing HTTP routes
class UserTest extends TestCase
{
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';
        Flight::halt(false);  // this is used to prevent auto-exit during test
        Flight::start();  // here we need to start the app
    }
    public function testGetAllUsers()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET'; //simulating HTTP requests
        $_SERVER['REQUEST_URI'] = '/users';
        ob_start();
        Flight::start(); //triggering routing to start the app
        $output = ob_get_clean(); //capturing the output
        $this->assertEquals(200, http_response_code()); //assert that HTTP response code is 200 (OK)
        $this->assertJson($output); //and assert that response is a valid json output/response
    }

    // Testing GET /restaurant/{id} Route
    public function testGetUserById()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/user/14'; //P.S.:passing 14 as id parameter, thus assuming user with id 14 exists (check in the db)
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"id":14', $output); //assert that certain content is present in the output
    }

    public function testGetUserPhoneById()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/user/14?type=phone';
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"phone":', $output);
    }

    public function testGetUserRoleById()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/user/14?type=role';
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"role":', $output);
    }



}


