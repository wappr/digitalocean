<?php

namespace wappr\digitalocean;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use wappr\digitalocean\Requests\DropletActions\DropletActionsRequest;

class DropletActionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var DropletActions
     */
    protected $dropletActions;

    public function setUp()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar']),
            new Response(200, []),
            new Response(200, []),
            new Response(200, []),
        ]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
        $this->dropletActions = new DropletActions($this->client);
    }

    public function testSuccessfulRequests()
    {
        $methods = [
            'enableBackups',
            'disableBackups',
            'reboot',
            'powerCycle',
            'shutdown',
            'powerOff',
            'powerOn',
            'passwordReset',
            'enableIPv6',
            'enablePrivateNetworking',
        ];

        foreach ($methods as $method) {
            $mock = new MockHandler([
                new Response(200),
            ]);
            $handler = HandlerStack::create($mock);
            $client = new Client(['handler' => $handler]);
            $dropletActions = new DropletActions($client);

            $result = $dropletActions->{$method}(new DropletActionsRequest('1234'));

            $this->assertInstanceOf(DropletActions::class, $result);
        }
    }

    public function testRestore()
    {
        $request = new DropletActionsRequest('1123');
        $result = $this->dropletActions->restore($request, '1234'/* image id */);
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testResize()
    {
        $request = new DropletActionsRequest('1123');
        $result = $this->dropletActions->resize($request, '1024mb'/* size */);
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testRebuild()
    {
        $request = new DropletActionsRequest('1123');
        $result = $this->dropletActions->rebuild($request, '1234'/* image id */);
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testRename()
    {
        $request = new DropletActionsRequest('1234');
        $result = $this->dropletActions->rename($request, 'new_name');
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testChangeKernel()
    {
        $request = new DropletActionsRequest('1234');
        $result = $this->dropletActions->changeKernel($request, '3.13.0-37-generic');
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testSnapshot()
    {
        $request = new DropletActionsRequest('1234');
        $result = $this->dropletActions->snapshot($request, 'before_i_do_something_risky');
        $this->assertInstanceOf(DropletActions::class, $result);
    }

    public function testRetrieve()
    {
        $request = new DropletActionsRequest('1234');
        $result = $this->dropletActions->retrieve($request, '12345678');
        $this->assertEquals($result->getStatusCode(), 200);
        $this->assertInstanceOf(Response::class, $result);
    }

    public function testMethodChaining()
    {
        $request = new DropletActionsRequest('1234');
        $result = $this->dropletActions->enableBackups($request)
                                        ->reboot($request)
                                        ->enableIPv6($request);
        $this->assertInstanceOf(DropletActions::class, $result);
    }
}
