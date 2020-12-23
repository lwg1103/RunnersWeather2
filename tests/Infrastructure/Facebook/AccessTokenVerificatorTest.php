<?php

namespace App\Tests\Infrastructure\Facebook;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Facebook\AccessTokenVerificator;
use Facebook\Facebook;
use PHPUnit\Framework\MockObject\MockObject;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\FacebookResponse;
use App\Application\Service\AuthTokenData;

class AccessTokenVerificatorTest extends TestCase
{
    const EXAMPLE_TOKEN = 'token';
    const EXAMPLE_EMAIL = 'email@dot.com';
    const DIFFERENT_EMAIL = 'email2@dot.com';
    
    /** @var AccessTokenVerificator*/
    private $testSubject;
    
    /** @var Facebook|MockObject */
    private $facebookMock;
    
    private $result;
    
    public function testVerificationReturnsFalseIfEmailWasntProvided()
    {
        $this->whenDoVerification(self::EXAMPLE_TOKEN, null)
                ->thenVerificationFailed();
    }
    
    public function testVerificationReturnsFalseIfFBThrowsException()
    {
        $this->givenTokenVerificationEndsWithException()
                ->whenDoVerification(self::EXAMPLE_TOKEN, self::EXAMPLE_EMAIL)
                ->thenVerificationFailed();
    }
    
    public function testVerificationReturnsFalseIfFBReturnsDifferentEmail()
    {
        $this->givenFacebookReturnsEmail(self::DIFFERENT_EMAIL)
                ->whenDoVerification(self::EXAMPLE_TOKEN, self::EXAMPLE_EMAIL)
                ->thenVerificationFailed();
    }
    
    public function testVerificationReturnsTrueIfTokenIsAssignedToCorrectEmail()
    {
        $this->givenFacebookReturnsEmail(self::EXAMPLE_EMAIL)
                ->whenDoVerification(self::EXAMPLE_TOKEN, self::EXAMPLE_EMAIL)
                ->thenVerificationPass();
    }
    
    protected function setUp()
    {
        $this->facebookMock = $this->getMockBuilder(Facebook::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $this->testSubject = new AccessTokenVerificator($this->facebookMock);
    }
    
    private function givenTokenVerificationEndsWithException()
    {
        $exception = $this->getMockBuilder(FacebookResponseException::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        
        $this->facebookMock->method('get')
            ->willThrowException($exception);
        
        return $this;
    }
    
    private function givenFacebookReturnsEmail(string $email)
    {
        $responseMock = $this->getMockBuilder(FacebookResponse::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $responseMock->method('getGraphUser')
            ->willReturn(['email' => $email]);
        
        $this->facebookMock->method('get')
            ->willReturn($responseMock);
        
        return $this;
    }
    
    private function whenDoVerification($token, $email)
    {
        $tokenData = new AuthTokenData($email, $token);
        $this->result = $this->testSubject->verify($tokenData);
        
        return $this;
    }
    
    private function thenVerificationFailed()
    {
        $this->assertFalse($this->result);
        
        return $this;
    }
    
    private function thenVerificationPass()
    {
        $this->assertTrue($this->result);
        
        return $this;
    }
        
}
