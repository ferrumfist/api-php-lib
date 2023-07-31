<?php
// Copyright 1999-2023. Plesk International GmbH.

namespace PleskXTest;

class SessionTest extends AbstractTestCase
{
    public function testCreate()
    {
        self::markTestSkipped('rename admin login');
        $sessionToken = static::$client->session()->create('admin', '127.0.0.1');

        $this->assertIsString($sessionToken);
        $this->assertGreaterThan(10, strlen($sessionToken));
    }

    public function testGet()
    {
        self::markTestSkipped('rename admin login');
        $sessionId = static::$client->server()->createSession('admin', '127.0.0.1');
        $sessions = static::$client->session()->get();
        $this->assertArrayHasKey($sessionId, $sessions);

        $sessionInfo = $sessions[$sessionId];
        $this->assertEquals('admin', $sessionInfo->login);
        $this->assertEquals('127.0.0.1', $sessionInfo->ipAddress);
        $this->assertEquals($sessionId, $sessionInfo->id);
    }

    public function testTerminate()
    {
        self::markTestSkipped('rename admin login');
        $sessionId = static::$client->server()->createSession('admin', '127.0.0.1');
        static::$client->session()->terminate($sessionId);
        $sessions = static::$client->session()->get();
        $this->assertArrayNotHasKey($sessionId, $sessions);
    }
}
