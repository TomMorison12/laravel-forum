<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /* A basic test example.
     *
     * @return void
     */
    protected $thread;

    public function setUp() {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_user_can_browse_all_threads() {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);

        $response = $this->get('/threads/'. $this->thread->channel->name .'/'. $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread() {


        $response = $this->get('/threads/'. $this->thread->channel->name.'/'. $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/'.$this->thread->channel->name.'/'.$this->thread->id)->assertSee($reply->body);
    }

    public function test_a_thread_has_replies() {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function test_a_thread_has_a_creator() {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->creator);

    }

    public function test_a_thread_can_add_a_reply() {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);

    }

    function test_a_thread_belongs_to_a_channel() {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    function test_a_thread_can_make_a_string_path() {

        $thread = create('App\Thread');

         $this->assertEquals('/threads/'. $thread->channel->name. '/'. $thread->id, $thread->path());
    }

    public function test_a_user_can_filter_threads_according_to_tag() {
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }




}
