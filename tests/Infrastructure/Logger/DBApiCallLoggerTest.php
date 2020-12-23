<?php

namespace App\Tests\Infrastructure\Logger;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Logger\DBApiCallLogger;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Entity\ApiRequestLog;
use App\Application\Entity\User;

class DBApiCallLoggerTest extends TestCase {

    const LONG = 12.34;
    const LAT = 23.45;

    /** @var  DBApiCallLogger */
    private $DBApiCallLogger;

    /** @var EntityManagerInterface */
    private $EntityManagerMock;
    
    /** @var User */
    private $UserMock;

    public function testPersistAndFlushLog() {
        $this->thenApiLogIsSaved()
                ->whenLogRequestForCoordinates();
    }

    protected function setUp() {
        $this->EntityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->DBApiCallLogger = new DBApiCallLogger($this->EntityManagerMock);
        
        $this->UserMock = $this->getMockBuilder(User::class)
                ->disableOriginalConstructor()
                ->getMock();

        parent::setUp();
    }

    private function thenApiLogIsSaved() {
        $ApiLog = new ApiRequestLog(self::LAT, self::LONG, $this->UserMock);
        
        $this->EntityManagerMock->expects($this->once())
                ->method('persist')
                ->with($ApiLog);

        $this->EntityManagerMock->expects($this->once())
                ->method('flush');

        return $this;
    }

    private function whenLogRequestForCoordinates() {
        $this->DBApiCallLogger->log(self::LAT, self::LONG, $this->UserMock);

        return $this;
    }

}
