<?php

use BajakLautMalaka\PmiAdmin\Tests\TestCase;
use BajakLautMalaka\PmiAdmin\Admin;

class AdminUnitTest extends TestCase
{
    /**
     * @test
     */
    public function coba()
    {
        //$response = $this->json('POST', 'api/admin/login', ['email' => 'admin@mail.com','password'=>'Open1234']);
        //$response->dump();
        $admin = factory(Admin::class)->create();
        //dump($admin->createToken('PMI')->accessToken);
        $this->assertTrue(true);
    }
}