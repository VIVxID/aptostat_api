<?php

use aptostatApi\Service\ReportService;

class ReportServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ReportService;
     */
    private $reportService;

    protected function setUp()
    {
        $this->reportService = new ReportService();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetReportByIdShouldThrowInvalidArgumentExceptionIfNoIdIsProvided()
    {
        $this->reportService->getReportByIncidentId('');
    }
}
