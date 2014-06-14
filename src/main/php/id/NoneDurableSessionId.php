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
 * Session id which is always created new.
 *
 * @since  2.0.0
 */
class NoneDurableSessionId implements SessionId
{
    /**
     * actual id
     *
     * @type  string
     */
    private $id;
    /**
     * name of session
     *
     * @type  string
     */
    private $sessionName;

    /**
     * returns session name
     *
     * @return  string
     */
    public function name()
    {
        if (null === $this->sessionName) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $this->sessionName = '';
            for ($i = 0; $i < 32; $i++) {
                $this->sessionName .= $characters[rand(0, strlen($characters) - 1)];
            }
        }

        return $this->sessionName;
    }

    /**
     * reads session id
     *
     * @return  string
     */
    public function __toString()
    {
        if (null === $this->id) {
            $this->id = $this->create();
        }

        return $this->id;
    }

    /**
     * creates session id
     *
     * @return  string
     */
    private function create()
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * stores session id for given session name
     *
     * @return  SessionId
     */
    public function regenerate()
    {
        $this->id = $this->create();
        return $this;
    }

    /**
     * invalidates session id
     *
     * @return  SessionId
     */
    public function invalidate()
    {
        return $this;
    }
}
