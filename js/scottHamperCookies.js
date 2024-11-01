/*!
 * scottHamperCookies.js - 0.3.1
 * Wednesday, April 24 2013 @ 2:28 AM EST
 *
 * Copyright (c) 2013, Scott Hamper
 * Licensed under the MIT license,
 * http://www.opensource.org/licenses/MIT
 */
(function (undefined) {
    'use strict';

    var scottHamperCookies = function (key, value, options) {
        return arguments.length === 1 ?
            scottHamperCookies.get(key) : scottHamperCookies.set(key, value, options);
    };

    // Allows for setter injection in unit tests
    scottHamperCookies._document = document;
    scottHamperCookies._navigator = navigator;

    scottHamperCookies.defaults = {
        path: '/'
    };

    scottHamperCookies.get = function (key) {
        if (scottHamperCookies._cachedDocumentCookie !== scottHamperCookies._document.cookie) {
            scottHamperCookies._renewCache();
        }

        return scottHamperCookies._cache[key];
    };

    scottHamperCookies.set = function (key, value, options) {
        options = scottHamperCookies._getExtendedOptions(options);
        options.expires = scottHamperCookies._getExpiresDate(value === undefined ? -1 : options.expires);

        scottHamperCookies._document.cookie = scottHamperCookies._generateCookieString(key, value, options);

        return scottHamperCookies;
    };

    scottHamperCookies.expire = function (key, options) {
        return scottHamperCookies.set(key, undefined, options);
    };

    scottHamperCookies._getExtendedOptions = function (options) {
        return {
            path: options && options.path || scottHamperCookies.defaults.path,
            domain: options && options.domain || scottHamperCookies.defaults.domain,
            expires: options && options.expires || scottHamperCookies.defaults.expires,
            secure: options && options.secure !== undefined ?  options.secure : scottHamperCookies.defaults.secure
        };
    };

    scottHamperCookies._isValidDate = function (date) {
        return Object.prototype.toString.call(date) === '[object Date]' && !isNaN(date.getTime());
    };

    scottHamperCookies._getExpiresDate = function (expires, now) {
        now = now || new Date();
        switch (typeof expires) {
            case 'number': expires = new Date(now.getTime() + expires * 1000); break;
            case 'string': expires = new Date(expires); break;
        }

        if (expires && !scottHamperCookies._isValidDate(expires)) {
            throw new Error('`expires` parameter cannot be converted to a valid Date instance');
        }

        return expires;
    };

    scottHamperCookies._generateCookieString = function (key, value, options) {
        key = encodeURIComponent(key);
        value = (value + '').replace(/[^!#$&-+\--:<-\[\]-~]/g, encodeURIComponent);
        options = options || {};

        var cookieString = key + '=' + value;
        cookieString += options.path ? ';path=' + options.path : '';
        cookieString += options.domain ? ';domain=' + options.domain : '';
        cookieString += options.expires ? ';expires=' + options.expires.toUTCString() : '';
        cookieString += options.secure ? ';secure' : '';

        return cookieString;
    };

    scottHamperCookies._getCookieObjectFromString = function (documentCookie) {
        var cookieObject = {};
        var cookiesArray = documentCookie ? documentCookie.split('; ') : [];

        for (var i = 0; i < cookiesArray.length; i++) {
            var cookieKvp = scottHamperCookies._getKeyValuePairFromCookieString(cookiesArray[i]);

            if (cookieObject[cookieKvp.key] === undefined) {
                cookieObject[cookieKvp.key] = cookieKvp.value;
            }
        }

        return cookieObject;
    };

    scottHamperCookies._getKeyValuePairFromCookieString = function (cookieString) {
        // "=" is a valid character in a cookie value according to RFC6265, so cannot `split('=')`
        var separatorIndex = cookieString.indexOf('=');

        // IE omits the "=" when the cookie value is an empty string
        separatorIndex = separatorIndex < 0 ? cookieString.length : separatorIndex;

        return {
            key: decodeURIComponent(cookieString.substr(0, separatorIndex)),
            value: decodeURIComponent(cookieString.substr(separatorIndex + 1))
        };
    };

    scottHamperCookies._renewCache = function () {
        scottHamperCookies._cache = scottHamperCookies._getCookieObjectFromString(scottHamperCookies._document.cookie);
        scottHamperCookies._cachedDocumentCookie = scottHamperCookies._document.cookie;
    };

    scottHamperCookies._areEnabled = function () {
        return scottHamperCookies._navigator.cookieEnabled ||
            scottHamperCookies.set('cookies.js', 1).get('cookies.js') === '1';
    };

    scottHamperCookies.enabled = scottHamperCookies._areEnabled();

    // AMD support
    if (typeof define === 'function' && define.amd) {
        define(function () { return scottHamperCookies; });
    // CommonJS and Node.js module support.
    } else if (typeof exports !== 'undefined') {
        // Support Node.js specific `module.exports` (which can be a function)
        if (typeof module !== 'undefined' && module.exports) {
            exports = module.exports = scottHamperCookies;
        }
        // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
        exports.scottHamperCookies = scottHamperCookies;
    } else {
        window.scottHamperCookies = scottHamperCookies;
    }
})();

