5.0.1 (2014-10-14)
------------------

  * added constructor to `stubbles\webapp\session\id\NoneDurableSessionId` that allows to predefine session name and fixate session id


5.0.0 (2014-08-17)
------------------

### BC breaks

  * session instance creation functions `stubbles\webapp\session\native()` and `stubbles\webapp\session\noneDurable()` now return the session instance directly instead of a callable
  * removed `stubbles\webapp\session\bind()`
  * removed `stubbles\webapp\session\ioc\SessionBindingScope`, is now part of stubbles/webapp-core


### Other changes

  * added `stubbles\webapp\session\nullSession()`
  * fixed `stubbles\webapp\session\noneDurable()` to create a session which at least stores values within the request
  * removed dependency to stubbles/core
  * removed dependency to stubbles/input


4.0.0 (2014-07-31)
------------------

  * Initial release after split off from stubbles/webapp-core
