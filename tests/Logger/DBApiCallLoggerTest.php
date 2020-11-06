<?php

namespace App\Tests\Logger;

use PHPUnit\Framework\TestCase;
use App\Logger\DBApiCallLogger;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApiRequest\ApiRequestLog;

class DBApiCallLoggerTest extends TestCase {

    const LONG = 12.34;
    const LAT = 23.45;

    /** @var  DBApiCallLogger */
    private $DBApiCallLogger;

    /** @var EntityManagerInterface */
    private $EntityManagerMock;

    public function testPersistAndFlushLog() {
        $this->thenApiLogIsSaved()
                ->whenLogRequestForCoordinates();
    }

    protected function setUp() {
        $this->EntityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->DBApiCallLogger = new DBApiCallLogger($this->EntityManagerMock);

        parent::setUp();
    }

    private function thenApiLogIsSaved() {
        $ApiLog = new ApiRequestLog(self::LAT, self::LONG, 0);
        
        $this->EntityManagerMock->expects($this->once())
                ->method('persist')
                ->with($ApiLog);

        $this->EntityManagerMock->expects($this->once())
                ->method('flush');

        return $this;
    }

    private function whenLogRequestForCoordinates() {
        $this->DBApiCallLogger->log(self::LAT, self::LONG);

        return $this;
    }

}
