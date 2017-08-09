<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    use \Illuminate\Foundation\Testing\WithoutMiddleware;
    //use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl;


    public function setUp()
    {
        parent::setUp();
        $this->baseUrl = env('APP_URL', 'http://localhost');
        auth()->attempt(['email' => 'me@ngocnh.info', 'password' => 'admin']);
        $this->be(auth()->user());
    }


    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
