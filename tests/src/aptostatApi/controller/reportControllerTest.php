<?php


namespace aptostatApi\Controller;
use Silex\Application;
use Silex\WebTestCase;

class reportControllerTest extends WebTestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../app/app.php';
        $app['debug'] = false;
        $app['exception_handler']->disable();

        return $app;
    }

    public function testIndexActionShouldReturn200WhenReportsAreFound()
    {
        $client = $this->createClient();
        $client->request('GET', '/api/report');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexActionShouldIncludeReportElement()
    {
        $client = $this->createClient();
        $client->request('GET', '/api/report');
        $body = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('report', $body);
    }
}
