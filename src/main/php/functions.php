<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\webapp\session
 */
namespace stubbles\webapp\session {
    use stubbles\webapp\session\NullSession;
    use stubbles\webapp\session\WebSession;
    use stubbles\webapp\session\id\NoneDurableSessionId;
    use stubbles\webapp\session\storage\ArraySessionStorage;
    use stubbles\webapp\session\storage\NativeSessionStorage;

    /**
     * returns a callable which creates a session based on php's session implementation
     *
     * @param   string  $sessionName  name of session to create
     * @param   string  $fingerPrint  unique fingerprint for user agent
     * @return  \stubbles\webapp\session\WebSession
     * @since   4.0.0
     */
    function native($sessionName, $fingerPrint)
    {
        $native = new NativeSessionStorage($sessionName);
        return new WebSession($native, $native, $fingerPrint);
    }

    /**
     * creates a session which is not durable between requests
     *
     * The resulting session will create a new session id with each request. It
     * does not store any values between requests.
     *
     * @return  \stubbles\webapp\session\WebSession
     * @since   4.0.0
     */
    function noneDurable()
    {
        return new WebSession(new ArraySessionStorage(), new NoneDurableSessionId(), uniqid());
    }

    /**
     * creates a session which does nothing, not even storing any values
     *
     * @return  \stubbles\webapp\session\NullSession
     * @since   5.0.0
     */
    function nullSession()
    {
        return new NullSession(new NoneDurableSessionId());
    }
}

