<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\webapp\session
 */
namespace stubbles\webapp\session\processor;
use stubbles\input\web\useragent\UserAgent;
use stubbles\webapp\processor\HtmlFilePassThrough;
use stubbles\webapp\session\Session;
/**
 * Processor to pass through hole HTML pages to ensure session ids are passed in links.
 *
 * @since  4.0.0
 */
class SessionBasedHtmlFilePassThrough extends HtmlFilePassThrough
{
    /**
     * current user agent
     *
     * @type  UserAgent
     */
    private $userAgent;
    /**
     * the selected route
     *
     * @type  Session
     */
    private $session;

    /**
     * constructor
     *
     * @param  string     $routePath  path to html files
     * @param  UserAgent  $userAgent  user agent of current request
     * @param  Session    $session    current session
     * @Inject
     * @Named{routePath}('stubbles.pages.path')
     */
    public function __construct($routePath, UserAgent $userAgent, Session $session)
    {
        parent::__construct($routePath);
        $this->userAgent = $userAgent;
        $this->session   = $session;
    }

    /**
     * hook to modify the content before passing it to the response
     *
     * @param   string  $content    actual content for response
     * @param   string  $routeName  name of the route
     * @return  string
     */
    protected function modifyContent($content, $routeName)
    {
        $this->session->putValue('stubbles.webapp.lastPage', $routeName);
        if (!$this->userAgent->acceptsCookies()) {
            output_add_rewrite_var($this->session->name(), $this->session->id());
        }

        return $content;
    }
}
