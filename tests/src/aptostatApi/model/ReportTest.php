<?php


class ReportTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \aptostatApi\model\Report
     */
    private $report;

    protected function setUp()
    {
        $this->report = new \aptostatApi\model\Report();
    }

    public function testQueryShouldReturn400IfNoIdIsProvided()
    {
        $response = $this->report->query('');

        $this->assertEquals(400, $response);
    }
}
