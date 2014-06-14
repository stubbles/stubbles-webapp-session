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
    use stubbles\input\web\WebRequest;
    use stubbles\ioc\Binder;
    use stubbles\webapp\response\Response;
    use stubbles\webapp\session\NullSession;
    use stubbles\webapp\session\Session;
    use stubbles\webapp\session\WebSession;
    use stubbles\webapp\session\id\NoneDurableSessionId;
    use stubbles\webapp\session\id\WebBoundSessionId;
    use stubbles\webapp\session\ioc\SessionBindingScope;
    use stubbles\webapp\session\storage\NativeSessionStorage;

    /**
     * returns a callable which creates a session based on php's session implementation
     *
     * @param   string  $sessionName  name of session to create
     * @return  callable
     * @since   4.0.0
     */
    function native($sessionName)
    {
        return function(WebRequest $request) use($sessionName)
               {
                   $native = new NativeSessionStorage($sessionName);
                   return new WebSession($native, $native, md5($request->readHeader('HTTP_USER_AGENT')->unsecure()));
               };
    }

    /**
     * returns a callable which creates a session that is not durable between requests
     *
     * The resulting session will create a new session id with each request. It
     * does not store any values between requests.
     *
     * @return  callable
     * @since   4.0.0
     */
    function noneDurable()
    {
        return function()
               {
                   return new NullSession(new NoneDurableSessionId());
               };
    }

    /**
     * returns a callable which creates a session that is durable between requests but does not store any values
     *
     * The resulting session will keep the session id between requests, but not
     * any value that is stored within the session.
     *
     * @param   string  $sessionCookieName  name of cookie to store session id in
     * @return  callable
     * @since   4.0.0
     */
    function noneStoring($sessionCookieName)
    {
        return function(WebRequest $request, Response $response) use($sessionCookieName)
               {
                   return new NullSession(new WebBoundSessionId($request, $response, $sessionCookieName));
               };
    }

    /**
     * binds session and creates a session scope
     *
     * @param  Binder   $binder
     * @param  Session  $session
     * @since  4.0.0
     */
    function bind(Binder $binder, Session $session)
    {
        $binder->bind('stubbles\webapp\session\Session')->toInstance($session);
        $binder->setSessionScope(new SessionBindingScope($session));
    }
}

