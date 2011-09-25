#turnip#

...is a small php-5.3 **application framework**, cleverly disguised as a turnip.

##current goals:##

* Improve application structure, namely around `ext`, `view` and `extension`.
* Implement caching library - generating route information is somewhat costly, and the current implementation will not function as expected with APC. (comments are not stored in the opcode cache).
* Implement `view` adapters.
* Implement `cli` interface (under `client`).
* Extend named parameters (`router`) with conditions, filters?
* Improve `@route`-related code - the regular expression in particular could be improved.
* Add support for method decorators? (for routes).

##license##

turnip is available under the terms of the GNU General Public License 3.