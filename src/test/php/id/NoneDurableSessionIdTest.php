<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\webapp\session
 */
namespace stubbles\webapp\session\id;
/**
 * Tests for stubbles\webapp\session\id\NoneDurableSessionId.
 *
 * @since  2.0.0
 * @group  session
 * @group  id
 */
class NoneDurableSessionIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance to test
     *
     * @type  NoneDurableSessionId
     */
    private $noneDurableSessionId;

    /**
     * set up test enviroment
     */
    public function setUp()
    {
        $this->noneDurableSessionId = new NoneDurableSessionId('foo');
    }

    /**
     * @test
     */
    public function returnsGivenSessionName()
    {
        $this->assertEquals('foo', $this->noneDurableSessionId->getName());
    }

    /**
     * @test
     */
    public function hasSessionId()
    {
        $this->assertRegExp('/^([a-zA-Z0-9]{32})$/D',
                            $this->noneDurableSessionId->get()
        );
    }

    /**
     * @test
     */
    public function regenerateChangesSessionId()
    {
        $previous = $this->noneDurableSessionId->get();
        $this->assertNotEquals($previous,
                               $this->noneDurableSessionId->regenerate()
                                                          ->get()
        );
    }

    /**
     * @test
     */
    public function regeneratedSessionIdIsValid()
    {
        $this->assertRegExp('/^([a-zA-Z0-9]{32})$/D',
                            $this->noneDurableSessionId->regenerate()
                                                       ->get()
        );
    }

    /**
     * @test
     */
    public function invalidateDoesNothing()
    {
        $this->assertSame($this->noneDurableSessionId,
                          $this->noneDurableSessionId->invalidate()
        );
    }
}
