<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\webapp\session
 */
namespace stubbles\webapp\session;
use stubbles\input\ValueReader;
use stubbles\ioc\Binder;
/**
 * Tests for stubbles\webapp\session\*().
 *
 * @since  4.0.0
 * @group  session
 */
class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function nativeCreatesWebSession()
    {
        $sessionCreator = native('example');
        $mockRequest    = $this->getMock('stubbles\input\web\WebRequest');
        $mockRequest->expects($this->once())
                    ->method('readHeader')
                    ->will($this->returnValue(ValueReader::forValue('example user agent')));
        $this->assertInstanceOf(
                'stubbles\webapp\session\WebSession',
                 $sessionCreator($mockRequest)
        );
    }

    /**
     * @test
     */
    public function noneDurableCreatesNullSession()
    {
        $sessionCreator = noneDurable();
        $this->assertInstanceOf(
                'stubbles\webapp\session\NullSession',
                 $sessionCreator()
        );
    }

    /**
     * @test
     */
    public function noneStoringCreatesNullSession()
    {
        $sessionCreator = noneStoring('example');
        $this->assertInstanceOf(
                'stubbles\webapp\session\NullSession',
                 $sessionCreator(
                        $this->getMock('stubbles\input\web\WebRequest'),
                        $this->getMock('stubbles\webapp\response\Response')
                 )
        );
    }

    /**
     * @test
     */
    public function noneStoringUsesGivenSessionName()
    {
        $sessionCreator = noneStoring('example');
        $this->assertEquals(
                'example',
                 $sessionCreator(
                        $this->getMock('stubbles\input\web\WebRequest'),
                        $this->getMock('stubbles\webapp\response\Response')
                 )->name()
        );
    }

    /**
     * @test
     */
    public function bindBindsSessionToPassedInstance()
    {
        $binder = new Binder();
        $mockSession = $this->getMock('stubbles\webapp\session\Session');
        bind($binder, $mockSession);
        $this->assertSame(
                $mockSession,
                $binder->getInjector()->getInstance('stubbles\webapp\session\Session')
        );
    }

    /**
     * @test
     */
    public function bindInitializesSessionScope()
    {
        $binder = new Binder();
        $mockSession = $this->getMock('stubbles\webapp\session\Session');
        bind($binder, $mockSession);
        try {
            $binder->bind('\stdClass')
                   ->to('\stdClass')
                   ->inSession();
        } catch (RuntimeException $re) {
            $this->fail($re->getMessage());
        }

        $this->addToAssertionCount(1);
    }
}
