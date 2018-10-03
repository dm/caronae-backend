<?php

namespace Tests\notifications;

use Caronae\Models\Ride;
use Caronae\Models\User;
use Caronae\Notifications\RideUserLeft;
use Mockery;
use Tests\TestCase;

class RideUserLeftTest extends TestCase
{
	protected $notification;

	public function setUp()
    {
        $ride = Mockery::mock(Ride::class);
    	$ride->shouldReceive('getAttribute')->with('id')->andReturn(1);

    	$user = Mockery::mock(User::class);
    	$user->shouldReceive('getAttribute')->with('id')->andReturn(2);

        $this->notification = new RideUserLeft($ride, $user);
        $this->notification->id = uniqid();
	}

    /** @test */
    public function should_contain_all_fields_in_push()
    {
        $this->assertSame([
            'id'       => $this->notification->id,
            'message'  => 'Um caronista desistiu de sua carona',
            'msgType'  => 'quitter',
            'rideId'   => 1,
            'senderId' => 2,
        ], $this->notification->toPush(Mockery::mock(User::class)));
    }
}
