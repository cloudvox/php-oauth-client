# Release History

## 0.3.0
* **Breaks API!**, see README.md and `example` directory, all applications need
  to be updated!
* Introduce abstraction for scopes using a Scope class. This Scope class also
  needs to be used now for Api calls to indicate the requested Scope
* It is possible now to request no scope, but use the one the server returned
  (issue #10)
* Add missing TokenResponseException class (issue #11)
* Add support for default token type if the OAuth 2.0 AS does not return one,
  this violates the specification, but apparently this is used by SalesForce 
  (issue #13)
* Fix dealing with expired tokens: the token was removed, but the refresh
  token was not checked

## 0.2.0
* **Breaks API!**, see README.md and `example` directory, all applications need 
  to be updated!
* Major cleanup of `ClientConfig`, addition of `GoogleClientConfig`
* Cleanup of `Api` and `Callback` classes, move required dependencies to 
  constructor
* Introduce `AuthorizeException` for `Callback` class, thrown when the 
  authorization server returns a (non-fatal) error
* Fix the examples in `example` directory
* Some PSR2 code style fixes

## 0.1.1
* Fix PDO token storage backend again
* Update README to show how to use PDO
* Refactor AccessToken, RefreshToken, State and Token and make them check 
  more
* Add some Google helpers to the code
* Make SessionStorage way more reliable so it works with multiple users
  and client_config_ids in the same session storage

## 0.1.0
* Initial release
