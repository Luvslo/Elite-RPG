<?php

namespace Tests\Feature;

use App\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessageTest extends TestCase
{
    public function test_messages_with_users()
    {
        return Message::with('user')->get();
    }
}
