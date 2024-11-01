
// ***************************************************************************
// GREAT-KIWI-AJAX.JS
// (C) 2011 Peter Newman. All Rights Reserved.
// ***************************************************************************

// ===========================================================================
// Ajax
// ===========================================================================

    // ---------------------------------------------------------------
    // FROM: http://www.hunlock.com/blogs/The_Ultimate_Ajax_Object
    // ---------------------------------------------------------------

    // -----------------------------------------------------------------------
    // hunlocksUltimateAjaxObject()
    //
    //  The reason for the big long name is of course, to minimise the risk
    //  of name conflicts ith anyone else's Ajax routines.
    // -----------------------------------------------------------------------

    // =======================================================================
    // CODE
    // =======================================================================

    // -----------------------------------------------------------------------
    // Hunlock's original code...
    // -----------------------------------------------------------------------

/*
function ajaxObject(url, callbackFunction) {
  var that=this;
  this.updating = false;
  this.abort = function() {
    if (that.updating) {
      that.updating=false;
      that.AJAX.abort();
      that.AJAX=null;
    }
  }
  this.update = function(passData,postMethod) {
    if (that.updating) { return false; }
    that.AJAX = null;
    if (window.XMLHttpRequest) {
      that.AJAX=new XMLHttpRequest();
    } else {
      that.AJAX=new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (that.AJAX==null) {
      return false;
    } else {
      that.AJAX.onreadystatechange = function() {
        if (that.AJAX.readyState==4) {
          that.updating=false;
          that.callback(that.AJAX.responseText,that.AJAX.status,that.AJAX.responseXML);
          that.AJAX=null;
        }
      }
      that.updating = new Date();
      if (/post/i.test(postMethod)) {
        var uri=urlCall+'?'+that.updating.getTime();
        that.AJAX.open("POST", uri, true);
        that.AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        that.AJAX.setRequestHeader("Content-Length", passData.length);
        that.AJAX.send(passData);
      } else {
        var uri=urlCall+'?'+passData+'&timestamp='+(that.updating.getTime());
        that.AJAX.open("GET", uri, true);
        that.AJAX.send(null);
      }
      return true;
    }
  }
  var urlCall = url;
  this.callback = callbackFunction || function () { };
}
*/

    // -----------------------------------------------------------------------
    // The Great Kiwi Version
    // - - - - - - - - - - -
    // 1)  Supports both Synchronous and Asynchronous Ajax
    //
    // 2)  The returns to the callback routines are
    //         statusCode , statusText , responseText , responseXML
    //     (instead of just:-
    //         responseText , status , responseXML
    //     )
    // -----------------------------------------------------------------------

    function hunlockUltimateAjaxObject( url , callbackFunction ) {

        var that=this;

        this.updating = false;

        this.abort = function() {
            if (that.updating) {
                that.updating=false;
                that.AJAX.abort();
                that.AJAX=null;
            }
        }

        this.update = function( passData , postMethod , question_asynchronous ) {

            // ---------------------------------------------------------------
            // hunlockUltimateAjaxObject.update(
            //      passData    ,
            //      postMethod
            //      )
            // - - - - - - - - - - - - - - - - -
            // RETURNS:-
            //      o   TRUE  if the Ajax call was made OK
            //      o   FALSE if the "update" function is "busy"
            //      o   NULL  if the browser has NO Ajax support
            // ---------------------------------------------------------------

            if ( that.updating ) {
                return false ;      //  "update" is BUSY (a previous Ajax
                                    //  call hasn't returned yet).
            }

            that.AJAX = null;

            if (window.XMLHttpRequest) {
                that.AJAX=new XMLHttpRequest();

            } else {
                that.AJAX=new ActiveXObject("Microsoft.XMLHTTP");

            }

            if (that.AJAX==null) {
                return null ;   //  Browser has NO Ajax support
            }

            if ( arguments.length < 3 ) {
                var question_asynchronous = true ;
            }

//alert( question_asynchronous ) ;
//alert( typeof question_asynchronous ) ;

            if ( question_asynchronous ) {
                that.AJAX.onreadystatechange = function() {
                    if (that.AJAX.readyState==4) {
                        that.updating=false;
                        that.callback(that.AJAX.status,that.AJAX.statusText,that.AJAX.responseText,that.AJAX.responseXML);
                        that.AJAX=null;
                    }
                }
            }

            that.updating = new Date();

            if (/post/i.test(postMethod)) {
                var uri=urlCall+'?'+that.updating.getTime();
                that.AJAX.open("POST", uri, question_asynchronous);
                that.AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                that.AJAX.setRequestHeader("Content-Length", passData.length);
                that.AJAX.send(passData);

            } else {
                var uri=urlCall+'?'+passData+'&timestamp='+(that.updating.getTime());
                that.AJAX.open("GET", uri, question_asynchronous);
                that.AJAX.send(null);

            }

            return true;

            // ---------------------------------------------------------------

        }

        var urlCall = url;

        this.callback = callbackFunction || function () { };

    }

    // =======================================================================
    // DOCS
    // =======================================================================

    //  ----------------------------------------------------------------------
    //  THE ULTIMATE AJAX OBJECT
    //
    //  Filed:  Thu, Mar 08 2007 under Programming
    //  Tags:   ajax javascript object post get
    //
    //  In my recent article "Ten Javascript Tools Everyone Should Have" I
    //  offered an AJAX object as the 10th tool. After publication, I received
    //  quite a number of requests to document the object, and so document it I
    //  shall.
    //
    //  INTRODUCTION
    //
    //  This object represents the pinnacle of my attempts to create a flexible
    //  and robust Ajax object. It's small, compact, object oriented, easy to
    //  follow and can handle multiple, concurrent, simultaneous requests,
    //  something the "hello world" tutorials always seem to miss. It's also
    //  public domain so use it and abuse it however you like and don't sweat
    //  giving up any precious screen space to credit me. So without further
    //  ado, here's the Ajax object. The documentation follows.
    //
    //  CREATING A NEW AJAXOBJECT
    //
    //  This AJAX snippet is a javascript object. You assign it to a variable
    //  the same way you assign a new Array(), or new Object(). This means you
    //  can have many variables, each one it's own little, discrete AJAX
    //  handler. You can even make an array of Ajax objects if you so desire.
    //  (be aware however that most browsers will only process two requests at a
    //  time. You can declare and start as many ajax requests as you want but
    //  only two requests will be processed at a time and the other requests
    //  will patiently wait their turn until they can be processed).
    //
    //  When you create the variable assignment, you pass the URL you want that
    //  that Ajax object to call. (And remember, Ajax requests are bound to the
    //  same domain as the web page. If you're on mydomain.com you'll get an
    //  error if you try to make an Ajax request to theirdomain.com).
    //
    //      var myRequest = new ajaxObject('http://www.somedomain.com/process.php');
    //
    //  DEFINING THE AJAX CALLBACK FUNCTION
    //
    //  If you would like to have a procedure to process the data returned by
    //  the server, add the function name you want to handle the request after
    //  the URL as such.
    //
    //      var myRequest = new ajaxObject('http://www.somedomain.com/process.php', processData);
    //
    //  This will tell myRequest to call processData when data has come back
    //  from the server. The first three arguments passed to processData will be
    //  responseText, responseStatus, and responseXML respectively. All three
    //  arguments are optional, you don't have to catch them if you don't want,
    //  although it is highly recommended you catch responseText and
    //  responseStatus as such...
    //
    //      function processData( responseText , responseStatus ) {
    //          if (responseStatus==200) {
    //              alert(responseText);
    //          } else {
    //              alert(responseStatus + ' -- Error Processing Request);
    //          }
    //      }
    //
    //  Here processData will accept responseText and responseStatus. If
    //  responseStatus is 200 (everything went a-ok) it will display the text
    //  from the server. If the response was not 200 it will display the error
    //  code and an error message.
    //
    //  Passing a callback function when declaring a new ajaxObject is optional.
    //  If you don't pass a function to call, ajaxObject will just discard any
    //  results it gets back from the server. This is useful when you don't need
    //  to process any return data for example when you're just notifying the
    //  server the mouse has passed over an object or that the page is being
    //  unloaded.
    //
    //  Having an external function to process the data is optional as well.
    //  External (or global) functions are useful if you have many ajax
    //  variables all calling the same response handler but if you're doing
    //  something unique you can more tightly bind the callback function with
    //  the ajax variable as such.
    //
    //      var myRequest = new ajaxObject('http://www.somedomain.com/process.php');
    //      myRequest.callback = function(responseText, responseStatus, responseXML) {
    //          // do stuff here.
    //      }
    //
    //  This inserts the callback function into the object instance itself. Note
    //  that you can't prototype this since callback is only set up in the
    //  constructor calls or via this method, a prototype would have no effect
    //  on new ajax constructors.
    //
    //  MAKING THE CALL: INITIATING THE AJAX REQUEST.
    //
    //  When you create your new variable assignment ajaxObject is initiated but
    //  no calls to the server will happen until you call the update method. The
    //  update method accepts two optional arguments, you can pass along some
    //  data to be sent to the server and you can specify that data be sent as a
    //  POST instead of a GET. (GET basically passes all your data in the URL,
    //  POST sends it differently so all the data doesn't show up in the server
    //  logs, plus you can send more data with POST than GET).
    //
    //  The format is as follows...
    //
    //      var myRequest = new ajaxObject('http://www.somedomain.com/process.php', processData);
    //      myRequest.update('id=1234&color=blue');  // Server is contacted here.
    //
    //  This would initiate an ajax call to the server, passing an id of 1234
    //  and color=blue to the server as a GET method. (in php it would set the
    //  variables $id and $color).
    //
    //  Remember, there's no actual request to the server until the update()
    //  method is called. Update will call the url the ajaxObject was
    //  constructed with and then, if there's a callback function (processData
    //  in this example) it will call that function when there's a response from
    //  the server.
    //
    //  SENDING DATA AS A POST IN AJAX
    //
    //  To send data to the server as a POST we'd use the following structure...
    //
    //      var myRequest = new ajaxObject('http://www.somedomain.com/process.php', processData);
    //      myRequest.update('id=1234&color=blue','POST');
    //
    //  This will send "id" and "color" to the server as a POST (in php
    //  $_POST['id'] and $_POST['color']. The "post" flag is not case sensitive
    //  it just needs to say post in the string.
    //
    //  TESTING THE UPDATE()
    //
    //  The update() method will return true if the Ajax call was successfully
    //  initialized. It will return false if you tried to start a new request
    //  while another request was already outstanding. Update() will also return
    //  false if the method was unable to initialize the browser's AJAX library
    //  (which means the browser is too old to have an xmlhttprequest object).
    //
    //  ESCAPE THE DATA
    //
    //  The update examples above are extremely simplified. To avoid problems
    //  with your data containing illegal characters and quotes you should
    //  escape the data before you pass it to update. If you want to pass three
    //  variables, you should at the very least prepare them as such...
    //
    //      passName = encodeURIComponent(name);
    //      passAge  = encodeURIComponent(age);
    //      passJob  = encodeURIComponent(job);
    //      sendString = 'name=' + passName + '&age=' + passAge + '&job=' + passJob;
    //      myRequest.update(sendString,'POST');
    //
    //  There are three escape commands in Javascript: escape, encodeURI, and
    //  encodeURIComponent. A very good explination of the three can be found at
    //  xkr.us. In general however, you will want to use encodeURIComponent()
    //  and avoid escape().
    //
    //  UPDATING
    //
    //  When you call the update() method the updating property is given a
    //  timestamp which you can use to see if a call is still in progress and
    //  how long the request has been processing. Here's a simple test to see if
    //  the object is updating.
    //
    //      if (myRequest.updating) {
    //          alert('this request is being processed.');
    //      } else {
    //          alert('this object is idle');
    //      }
    //
    //  YOU CAN ALSO SEE HOW LONG A REQUEST HAS BEEN PROCESSING....
    //
    //      if (myRequest.updating) {
    //          now=new Date();
    //          alert('This request is '+now-myRequest.updating+' miliseconds old.');
    //      }
    //
    //  ABORTING AN AJAX REQUEST
    //
    //  If you feel an Ajax request has gone on too long you can abort the
    //  request with the abort() method. This will issue an abort command and
    //  reset the object to an inactive state ready to accept a new update().
    //
    //      myRequest.abort();
    //
    //  If you call abort and there is no pending ajax call this method will
    //  have no effect.
    //
    //  PREVENTING CACHING FOR INTERNET EXPLORER
    //
    //  Even if you specify a POST method the URL will always be appended with a
    //  timestamp ('?timestamp=123412341243'). This timestamp is the javascript
    //  julian date integer, a number representing the number of milliseconds
    //  that have elapsed since Midnight, January 1, 1970 GMT. In php you can
    //  access the timestamp as $timestamp.
    //
    //  By appending the julian day number to the end of the URL we effectively
    //  make each call unique and that means Internet Explorer will not cache
    //  the Ajax call as it is wont to do.
    //
    //  COOL TRICKS AND TIPS
    //
    //  You don't actually need a server side script to use this object. It will
    //  pull a plain text file off your server without complaint. Of course the
    //  content won't be dynamic, it will just be the contents of that static
    //  file but if you're poping up a notice, ad, or flyer in a division this
    //  is a really nice way to get data dynamically after you've created the
    //  page.
    //
    //      myRequest = new ajaxObject('http://somedomain.com/ad.html');
    //      myRequest.callback = function(responseText) {
    //          document.getElementById('someAdDiv').innerHTML=responseText;
    //      }
    //      myRequest.update();
    //
    //  Since the ajaxObject can work with static files we can use it to load
    //  javascript libraries after the page has loaded so we can ask for them as
    //  we need them instead of sending a huge javascript library at the start
    //  which the user may not need.
    //
    //      myRequest = new ajaxObject('http://somedomain.com/javascriptLibrary.js');
    //      myRequest.callback = function(responseText) {
    //          eval(responseText);
    //      }
    //      myRequest.update();
    //
    //  As you can see, simulating a <script src="library.js"> call is as simple
	//  as passing the responseText through an eval statement (eval is basically
    //  the javascript compiler).
    //
    //  MULTIPLE AJAX CALLS, AJAX CONCURRENCY, AND DYNAMIC FLEXIBILITY
    //
    //  The beauty of encapsulating Ajax into an object is that you can define
    //  an Ajax request as easily as you can define a variable and keep the
    //  different requests as discrete as you can keep the values of different
    //  variables discrete.
    //
    //  Here is a simple code which defines three separate Ajax variables and
    //  binds them to three separate rss feeds (via a server-side script). The
    //  update method is called via links so when a feed is clicked on, the
    //  associated ajax request is called and the response is placed in a
    //  division named "feed".
    //
    //      function processFeed(responseText) {
    //          if (responseStatus==200) {
    //              document.getElementById('feed').innerHTML=responseText;
    //          }
    //      }
    //
    //      var diggFeed   = new ajaxObject('feedHandler.php',processFeed);
    //      var redditFeed = new ajaxObject('feedHandler.php',processFeed);
    //      var dzoneFeed  = new ajaxObject('feedHandler.php',processFeed);
    //
    //      <A HREF="" onClick='diggFeed.update("feed=http://www.digg.com/rss/index.xml"); return false;'>Get Digg Feed</A>
    //      <A HREF="" onClick='redditFeed.update("feed=http://reddit.com/.rss"); return false;'>Get Reddit Feed</A>
    //      <A HREF="" onClick='dzoneFeed.update("feed=http://feeds.dzone.com/dzone/frontpage"); return false;'>Get DZone Feed</A>
    //
    //  CHANGING THE CALLING AJAX URL
    //
    //  After you've created an ajaxObject you can update the URL and change the
    //  callback function if you need to by simply assigning a new ajaxObject as
    //  such.
    //
    //      var myRequest = new ajaxObject('serverScript.php',callbackFunc);
    //      myRequest.update();
    //
    //  Now we're going to change the URL
    //
    //      myRequest = new ajaxObject('newScript.php', newcallback);
    //      myRequest.update();
    //
    //  AN ARRAY OF AJAX OBJECTS!
    //
    //  Just for fun
    //
    //      ajaxArray=[];
    //      for (var i=0; i<10; i++) {
    //          ajaxArray[i] = new ajaxObject('someScript.php',callbackFunc);
    //      }
    //      // Call them all at once!
    //      for (i=0; i<10; i++) {
    //          ajaxArray[i].update('id='+i;);
    //      }
    //
    //  ----------------------------------------------------------------------

// ===========================================================================
// theGreatKiwiAjaxFunction()
// --------------------------
// This is a wrapper around the (Great Kiwi modified version of) Hunlock's
// "Ultimate Ajax Object".  The wrapper is to:-
//      a)  Make the Ajax easier to call, and;
//      b)  Add some extra features.
// ===========================================================================

    function theGreatKiwiAjaxFunction(
        url             ,
        query_params    ,
        method          ,
        options
        ) {

        // -------------------------------------------------------------------
        // theGreatKiwiAjaxFunction(
        //      url                 ,
        //      query_params        ,
        //      method              ,
        //      options
        //      ) {
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Makes the specified Ajax request.
        //
        // options = {
        //
        //      Property Name
        //		--------------------------------------------------------------
        //			Allowed Values						Default Value
        //      	----------------------------------  ----------------------
        //
        //      question_synchronous
        //			true | false						false
        //
        //      fail_silently
        //			true | false						false
        //
        //      fail_silently_cleanup_function
        //			null | function object  			null
        //
        //		show_response
        //			true | false						true
        //
        //      ok_or_error
        //			true | false						false
        //
        //      ok_or_error_cleanup_function
        //			null | function object  			null
        //
        // 		alert_function
        //			null | function name 				null
        //
        //      innerHTML_replace
        //			element id string            		(not specified)
        //
        //      innerHTML_append
        //			element id string					(not specified)
        //
        //      innerHTML_prepend
        //			element id string             		(not specified)
        //
        //      response_to
        //			null | function object  			null
        //
        //      callback_function
        //			null | function object  			null
        //
        //      passthru_obj
        //			null | {} | {...}					null
        //
        //      }       //
        //
        // NOTE that ALL "options" properties are OPTIONAL.  So an EMPTY
        // options array/object is perfectly OK.
        //
        // RETURNS:-
        //      o   TRUE on SUCCESS
        //      o   Error message STRING on FAILURE
        // -------------------------------------------------------------------

        // -------------------------------------------------------------------
        // theGreatKiwiAjaxFunction(
        //      url                 ,
        //      query_params        ,
        //      method              ,
        //      options
        //      ) {
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Makes the specified Ajax request...
        //
        //  ___
        //  url
        //
        //      Should be be like:-
        //          http://www.example.com/
        //
        //      Ie; It should contain just the SCHEME, DOMAIN NAME and
        //          (optionally) PATH parts; NOT the query parameters, etc.
        //
        //      NOTE!
        //      -----
        //      If URL specifies a directory, it MUST end in '/'.
        //
        //  ____________
        //  query_params
        //
        //      Can be either:-
        //
        //      o   A string like:-
        //              "this=xxx&that=yyy"
        //
        //          NOTE! NO leading "?"
        //
        //      o   An object like:-
        //              {   this    :   xxx     ,
        //                  that    :   yyy     }
        //
        //      NOTE!
        //      -----
        //      If the STRING format is used, it's assumed that the
        //      caller has url encoded the parameter values as required.
        //
        //      If the OBJECT format is used, the query string sent to
        //      the server will have ALL the parameters values encoded
        //      with "encodeURIComponent()" (whether they need it or
        //      not).
        //
        //  ______
        //  method
        //
        //      "get" or "post" (ANY CASE)
        //
        //  __________________
        //  options (OPTIONAL)
        //
        //      options = {
        //          Property Name                    Default Value
        //          ------------------------------   ----------------------
        //          question_synchronous           : false
        //          fail_silently                  : false
        //          fail_silently_cleanup_function : null
        //			show_response				   : true
        //          ok_or_error                    : false
        //          ok_or_error_cleanup_function   : null
        // 			alert_function				   : null
        //          innerHTML_replace              : element id
        //          innerHTML_append               : element id
        //          innerHTML_prepend              : element id
        //          response_to                    : null
        //          callback_function              : null
        //          passthru_obj                   : null
        //          }
        //
        //      An OBJECT that contains zero or more of the following
        //      (optional) parameters...
        //
        //      _________________________________________________
        //      question_synchronous (OPTIONAL - default = FALSE)
        //
        //          Make this TRUE if you want to make a SYNCHRONOUS
        //          call.  If NOT specified, the call will be
        //          asynchronous.
        //
        //          NOTE!
        //          -----
        //          Asynchronous calls are the norm for Ajax.
        //
        //          Synchronous Ajax calls DON'T return until the server
        //          responds (or timeout occurs).  Which means that the
        //          web page freezes until the server's response is
        //          received.
        //
        //          Which is generally speaking, a disaster.  Fortunately,
        //          it's rarely necessary to wait for server's response
        //          like this.
        //
        //      ____________________________________________
        //      fail_silently (OPTIONAL - defaults to FALSE)
        //
        //          By default, theGreatKiwiAjaxFunction() will pop up
        //          an alert like (eg):-
        //
        //              Ajax HTTP Request ERROR: <statusCode> - <statusText>
        //              While trying to access:-
        //                       URL: http://www.exaxmple.com
        //              QUERY PARAMS: this=one&that=two
        //                    METHOD: get
        //
        //          should the Ajax request return with a status that's
        //          anything other than 200 - OK!
        //
        //          Set fail_silently to TRUE to disable this.
        //
        //          NOTE!
        //          -----
        //          Disabling the NOT 200 warning message ISN'T a
        //          good idea.  Ajax libraries that don't alert the
        //          programmer/user when Ajax calls fail are probably
        //          one of the biggest causes of hard to find bugs in
        //          Ajax intensive pages.  Some functionality on the
        //          page just doesn't work for some reason.  And it
        //          can take a LOT of debugging to find out the cause
        //          is as simply as a failed Ajax call (due perhaps,
        //          to something as simple as a misspelt URL, or the
        //          like).
        //
        //          If you leave fail_silently FALSE - even on
        //          production/live servers - you'll save yourself and
        //          your end-users an awful lot of grief.
        //
        //      ____________________________________________________________
        //      fail_silently_cleanup_function (OPTIONAL - defaults to null)
        //
        //          A function to run if:-
        //          a)  "fail_silently" is disabled.  And:-
        //          b)  "statusCode" !== 200 triggers an early return from:-
        //                  theGreatKiwiAjaxFunction_standardResponseHandler()
        //
        //          In this case, the "callback_function" (if specified,)
        //          WON'T run.  So the "fail_silently_cleanup_function" can
        //          be specified to do any cleanup that might be required.
        //
        //          The "fail_silently_cleanup_function" is passed the same
        //          parameters as the "callback_function" (including any
        //          "passthru_obj" specified).
        //
        //      ___________________________________________
        //      show_response (OPTIONAL - defaults to TRUE)
        //
        //			Show the server's response - even if it's the empty
        //			or a white space only string.
        //
        //			NOTE!
        //			-----
        //			If the server's response is an empty of white space
        //			only string, a message to that effect will be
        //			displayed to the user (instead of the actual and
        //			invisible/meaningless response).
        //
        //      __________________________________________
        //      ok_or_error (OPTIONAL - defaults to FALSE)
        //
        //          This is a convenience function for use with Ajax calls
        //          that do something (like store data,) at the server - but
        //          DON'T return any data.
        //
        //          If you make these calls return:-
        //
        //          o   The STRING "--OK--" if everything went OK, or;
        //
        //          o   Some error message if the call failed for any reason.
        //
        //          then:-
        //
        //          o   If the call SUCCEEDED (and returned "--OK--"), then
        //              the response handler will exit without doing anything
        //              (which is generally what you want).  But:-
        //
        //          o   If the call FAILED (and returned some error message),
        //              then that error message will be displayed in the
        //              browser (eg; in an alert box).  Once the error message
        //              has been displayed, the response handler:-
        //                  theGreatKiwiAjaxFunction_standardResponseHandler()
        //              will return.  Thus, any pending "callback_function"
        //              WON'T be executed
        //
        //          This is very useful for debugging.  Since if PHP
        //          error_reporting() and display_errors are enabled (at the
        //          server), then even if the server-side script otherwise
        //          succeeds (and returns "--OK--"), the response will
        //          contain the PHP error or debugging output (eg; any
        //          Notices/Warnings/Fatal Errors issued by PHP, and any
        //          var_dumps(), etc, coded by you).  So, even if the
        //          server's response includes "--OK--", it won't equal
        //           "--OK--".  And so will be displayed in the browser.
        //          Which in general, in these situations, is exactly what
        //          you want.
        //
        //          NOTES!
        //          ------
        //
        //          1.  It's quite safe to enable "ok_or_error", even on
        //              live/production servers.  Just make sure that:-
        //              a)  You disable PHP error output.  Ie:-
        //                      error_reporting( NULL ) ;
        //                      ini_set( 'display_errors' , '0' ) ;
        //                  (as is normal good practice on these servers),
        //                  and;
        //              b)  You make sure that whenever your script detects
        //                  an error, it returns an informative, end-user
        //                  friendly error message.
        //
        //          2.  If your script returns neither "--OK--" nor an
        //              error message, (ie; if it returns the empty or a
        //              blank string), then with "ok_or_error" enabled the
        //              Ajax response handler will display an alert that
        //              the Ajax call has returned nothing - and therefore
        //              failed (for some unknown reason).
        //
        //          ---
        //
        //          "ok_or_error" is FALSE by default.  Set it to TRUE
        //          to enable it.
        //
        //      __________________________________________________________
        //      ok_or_error_cleanup_function (OPTIONAL - defaults to null)
        //
        //          A function to run if:-
        //          a)  "ok_or_error" is enabled.  And:-
        //          b)  "responseText" !== "--OK--" triggers an early
        //              return from:-
        //                  theGreatKiwiAjaxFunction_standardResponseHandler()
        //
        //          In this case, the "callback_function" (if specified,)
        //          WON'T run.  So the "ok_or_error_cleanup_function" can
        //          be specified to do any cleanup that might be required.
        //
        //          The "ok_or_error_cleanup_function" is passed the same
        //          parameters as the "callback_function" (including any
        //          "passthru_obj" specified).
        //
        //
        //		______________
        // 		alert_function
        //
        //			If null (the default), then whenever:-
        //				show_response, or;
        //				ok_or_error
        //
        //			want to display a message to the user, the standard Javascript
        //			"alert()" function will be called.
        //
        //			---
        //
        //			But if a function name is specified (and typeof , then that function will
        //			be called instead.has to be
        //			displayed to the usernull | function name 				null
        //
        //			This is useful for messages that contain HTML.  Alert
        //			boxes don't display HTML - the user sees the raw HTML
        //			tags instead.  Eg:-
        //
        //					Please enter <b>Email address</b>...
        //
        //			It's also useful for long messages.  Traditional alert
        //			boxes are limited to roughly 6 lines of text (it varies
        //			a lot though - depending on the user's browser).
        //
        //			The alert function you specify should work exactly like
        //			an alert box.  It should accept the message to be displayed
        //			as a string.  And display that message along with an
        //			"OK" (or similar) button.  Once the button is pressed
        //			your popup window shouldclose.  A popup with NO "OK"
        //			button can be used to - so long as it has something similar
        //			to the alert vboxes "OK" button - a "Close" button or "X"
        //			button (in the top right corner, for example.
        //
        //      _____________________________________________
        //      innerHTML_replace (OPTIONAL - defaults to "")
        //      innerHTML_append  (OPTIONAL - defaults to "")
        //      innerHTML_prepend (OPTIONAL - defaults to "")
        //
        //          If innerHTML_xxx points to a non-empty string, then the
        //          non-empty string is assumed to be the ID of some element
        //          on the page.  And the "responseText" replaces, appends
        //          to or prepends to that element's innerHTML.
        //
        //          If an element with the specified ID ISN'T found, an
        //          error message4 to this effect pops up in an alert box.
        //
        //          These are useful utility functions.  For use when you're
        //          requesteing some text, HTML, Javascript or CSS from the
        //          server, to be inserted into some existing element on
        //          the page.
        //
        //      _________________________________________
        //      response_to (OPTIONAL = defaults to null)
        //
        //          If "response_to" points to some function object, then
        //          that function is called as follows:-
        //
        //              options.response_to(
        //                  responseText    ,
        //                  responseXML     ,
        //                  passthru_obj
        //                  )
        //
        //          So "response_to" is a simplified version of the
        //          "callback_function".  Which recognises that in many
        //          cases, the Ajax call was to request some text or XML
        //          from the server.  Which text or XML the "response_to"
        //          function will now do something with.
        //
        //          We pass both "responseText" and "responseXML" to the
        //          "response_to" function - so that it can use whichever
        //          it pleases.
        //
        //          The "passthru_obj" is also passed to the "response_to"
        //          function, in case it contains some additional info.
        //          that the "response_to" function might need.
        //
        //          It's quite OK to specify BOTH a "response_to" function
        //          and a "callback_function" (though it's probably rather
        //          pointless).  But if both are specified, both will be
        //          called (with the "response_to" function being called
        //          first).
        //
        //      ____________________________
        //      callback_function (OPTIONAL)
        //
        //          Either:-
        //              o   null (to denote that there is NO callback
        //                  function), or;
        //
        //              o   A function object.
        //
        //          You define a callback function when you want to do
        //          something fancy with the response from the server.  In
        //          other words, when simple solutions like "ok_or_error"
        //          (see above,) just won't do.
        //
        //          The callback function is like:-
        //
        //              my_callback_function(
        //                  my_hunlock_ultimate_ajax_object_instance    ,
        //                  statusCode                                  ,
        //                  statusText                                  ,
        //                  responseText                                ,
        //                  responseXML
        //                  ) {
        //                  ...your code here...
        //              }
        //
        //          Presumably it will display messages and/or update
        //          the page HTML or DOM (based on the response from the
        //          server).
        //
        //          The callback function needn't return anything (because
        //          anything it does return is ignored).
        //
        //          See "my_callback_function()" below, for full details
        //          of the input parameter values supplied to this
        //          function.
        //
        //      _______________________
        //      passthru_obj (OPTIONAL)
        //
        //          A (possibly empty) object that holds any values you
        //          want to pass through to the callback function.
        //
        //          This object is ONLY used by the callback function.
        //          So if you DON'T specify a callback function, then
        //          passthru_obj is neither needed nor used.
        //
        // RETURNS:-
        //      o   TRUE on SUCCESS
        //      o   Error message STRING on FAILURE
        // -------------------------------------------------------------------

        // ===================================================================
        // ERROR CHECKING AND DEFAULT SETTING...
        // ===================================================================

        // -------------------------------------------------------------------
        // method
        // -------------------------------------------------------------------

        method = method.toLowerCase() ;

        // -------------------------------------------------------------------

        if ( method !== 'get' && method !== 'post' ) {

            return great_kiwi_ajax_function_failure(
                    'Must be "get" or "post" (any case)'
                    ) ;

        }

        // -------------------------------------------------------------------
        // options
        // -------------------------------------------------------------------

        if ( arguments.length < 4 ) {       //  "options" is OPTIONAL

            var options = {} ;

        } else if ( arguments.length > 4 ) {

            return great_kiwi_ajax_function_failure(
                    'This function has max. 4 parameters'
                    ) ;

        }

        // -------------------------------------------------------------------
        // options.question_synchronous
        // options['question_synchronous']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'question_synchronous' ) ) {

            if ( typeof options['question_synchronous'] !== 'boolean' ) {

                return great_kiwi_ajax_function_failure(
                        '"question_synchronous" must be true or false'
                        ) ;

            }

        } else {

            options['question_synchronous'] = false ;

        }

        // -------------------------------------------------------------------
        // options.fail_silently
        // options['fail_silently']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'fail_silently' ) ) {

            if ( typeof options['fail_silently'] !== 'boolean' ) {

                return great_kiwi_ajax_function_failure(
                        '"fail_silently" must be true or false'
                        ) ;

            }

        } else {

            options['fail_silently'] = false ;

        }

        // -------------------------------------------------------------------
        // options.fail_silently_cleanup_function
        // options['fail_silently_cleanup_function']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'fail_silently_cleanup_function' ) ) {

            if (    options['fail_silently_cleanup_function'] !== null
                    &&
                    typeof options['fail_silently_cleanup_function'] !== 'function'
                ) {

                return great_kiwi_ajax_function_failure(
                        '"fail_silently_cleanup_function" must be a function or null'
                        ) ;

            }

        } else {

            options['fail_silently_cleanup_function'] = null ;

        }

        // -------------------------------------------------------------------
        // options.show_response
        // options['show_response']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'show_response' ) ) {

            if ( typeof options['show_response'] !== 'boolean' ) {

                return great_kiwi_ajax_function_failure(
                        '"show_response" must be true or false'
                        ) ;

            }

        } else {

            options['show_response'] = true ;

        }

        // -------------------------------------------------------------------
        // options.ok_or_error
        // options['ok_or_error']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'ok_or_error' ) ) {

            if ( typeof options['ok_or_error'] !== 'boolean' ) {

                return great_kiwi_ajax_function_failure(
                        '"ok_or_error" must be true or false'
                        ) ;

            }

        } else {

            options['ok_or_error'] = false ;

        }

        // -------------------------------------------------------------------
        // options.ok_or_error_cleanup_function
        // options['ok_or_error_cleanup_function']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'ok_or_error_cleanup_function' ) ) {

            if (    options['ok_or_error_cleanup_function'] !== null
                    &&
                    typeof options['ok_or_error_cleanup_function'] !== 'function'
                ) {

                return great_kiwi_ajax_function_failure(
                        '"ok_or_error_cleanup_function" must be a function or null'
                        ) ;

            }

        } else {

            options['ok_or_error_cleanup_function'] = null ;

        }

        // -------------------------------------------------------------------
        // options.alert_function
        // options['alert_function']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'alert_function' ) ) {

            if ( typeof options['alert_function'] !== 'function' ) {

                return great_kiwi_ajax_function_failure(
                        'The "alert_function" doesn\'t exist'
                        ) ;

            }

        } else {

            options['alert_function'] = null ;

        }

        // -------------------------------------------------------------------
        // innerHTML_replace
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'innerHTML_replace' ) ) {

            if ( typeof options.innerHTML_replace !== 'string' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_replace" must be an element ID STRING'
                        ) ;

            } else if ( options.innerHTML_replace === '' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_replace" must be a NON-EMPTY element ID string'
                        ) ;

            } else if ( ! document.getElementById( options.innerHTML_replace ) ) {

                return great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_replace"'
                        ) ;

            }

        }

        // -------------------------------------------------------------------
        // innerHTML_append
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'innerHTML_append' ) ) {

            if ( typeof options.innerHTML_append !== 'string' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_append" must be an element ID STRING'
                        ) ;

            } else if ( options.innerHTML_append === '' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_append" must be a NON-EMPTY element ID string'
                        ) ;

            } else if ( ! document.getElementById( options.innerHTML_append ) ) {

                return great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_append"'
                        ) ;

            }

        }

        // -------------------------------------------------------------------
        // innerHTML_prepend
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'innerHTML_prepend' ) ) {

            if ( typeof options.innerHTML_prepend !== 'string' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_prepend" must be an element ID STRING'
                        ) ;

            } else if ( options.innerHTML_prepend === '' ) {

                return great_kiwi_ajax_function_failure(
                        '"innerHTML_prepend" must be a NON-EMPTY element ID string'
                        ) ;

            } else if ( ! document.getElementById( options.innerHTML_prepend ) ) {

                return great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_prepend"'
                        ) ;

            }

        }

        // -------------------------------------------------------------------
        // options.response_to
        // options['response_to']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'response_to' ) ) {

            if (    options['response_to'] !== null
                    &&
                    typeof options['response_to'] !== 'function'
                ) {

                return great_kiwi_ajax_function_failure(
                        '"response_to" must be a function or null'
                        ) ;

            }

        } else {

            options['response_to'] = null ;

        }

        // -------------------------------------------------------------------
        // options.callback_function
        // options['callback_function']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'callback_function' ) ) {

            if (    options['callback_function'] !== null
                    &&
                    typeof options['callback_function'] !== 'function'
                ) {

                return great_kiwi_ajax_function_failure(
                        '"callback_function" must be a function or null'
                        ) ;

            }

        } else {

            options['callback_function'] = null ;

        }

        // -------------------------------------------------------------------
        // options.passthru_obj
        // options['passthru_obj']
        // -------------------------------------------------------------------

        if ( options.hasOwnProperty( 'passthru_obj' ) ) {

            if (    typeof options['passthru_obj'] !== 'object'
                    ||
                    options['passthru_obj'] === null
            ) {

                return great_kiwi_ajax_function_failure(
                        '"passthru_obj" must be an object'
                        ) ;

            }

        } else {

            options['passthru_obj'] = {} ;

        }

        // ===================================================================
        // BUILD THE "PARAMS_STRING_4_SERVER"...
        // ===================================================================

        var params_string_4_server ;

        if ( typeof query_params === 'string' ) {

            //  TODO: Check for leading "?" !!!

            params_string_4_server = query_params ;

        } else if ( typeof query_params === 'object' ) {

            params_string_4_server = '' ;

            var comma = '' ;

            for ( name in query_params ) {
                params_string_4_server += comma + name + '=' + encodeURIComponent( query_params[name] ) ;
                comma = '&' ;
            }

        } else {

            return great_kiwi_ajax_function_failure(
                    '"query_params" must be a string or object'
                    ) ;

        }

        // ===================================================================
        // SEND THE AJAX REQUEST...
        // ===================================================================

        var my_hunlock_ultimate_ajax_object_instance =
                new hunlockUltimateAjaxObject(
                    url                                                 ,
                    theGreatKiwiAjaxFunction_standardResponseHandler
                    ) ;

        // -------------------------------------------------------------------

        my_hunlock_ultimate_ajax_object_instance.greatKiwiAjaxFunction_requestDetails = {
            url                 :   url                     ,
            params_as_input     :   query_params            ,
            params_string_sent  :   params_string_4_server  ,
            method              :   method                  ,
            options             :   options
            } ;

        // -------------------------------------------------------------------
        // hunlockUltimateAjaxObject.update(
        //      passData                ,
        //      postMethod              ,
        //      question_asynchronous
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   TRUE  if the Ajax call was made OK
        //      o   FALSE if the "update" function is "busy"
        //      o   NULL  if the browser has NO Ajax support
        // -------------------------------------------------------------------

        var result = my_hunlock_ultimate_ajax_object_instance.update(
                        params_string_4_server              ,
                        method                              ,
                        ! options['question_synchronous']
                        ) ;

        // -------------------------------------------------------------------

        if ( result === false ) {

            return great_kiwi_ajax_function_failure(
                    '"hunlockUltimateAjaxObject.update()" is busy (with an existing Ajax call).\n\n\tPlease try again later (or refresh your browser).'
                    ) ;

        } else if ( result === null ) {

            return great_kiwi_ajax_function_failure(
                    'Either your browser has Javascript disabled.\n\n\tOr it doesn\'t support Ajax.'
                    ) ;

        } else if ( result !== true ) {

            return great_kiwi_ajax_function_failure(
                    'Unexpected return value from "hunlockUltimateAjaxObject.update()"'
                    ) ;

        }

        // ===================================================================
        // SUCCESS!
        // ===================================================================

        return true ;

        // -------------------------------------------------------------------

    }

// ===========================================================================
// great_kiwi_ajax_function_failure()
// ===========================================================================

    function great_kiwi_ajax_function_failure( msg ) {
        return 'PROBLEM: "theGreatKiwiAjaxFunction()" failed because:-\n\n\t"' + msg ;
    }

// ===========================================================================
// theGreatKiwiAjaxFunction_standardResponseHandler(
// ===========================================================================

    function theGreatKiwiAjaxFunction_standardResponseHandler(
        statusCode      ,
        statusText      ,
        responseText    ,
        responseXML
        ) {

        // -------------------------------------------------------------------
        // NOTE!
        // -----
        // 1.   This is NOT the "callback function" that YOU create to
        //      handle your Ajax call's response.
        //
        //      Instead "theGreatKiwiAjaxFunction_standardResponseHandler()"
        //      first does some standard response handling.  And then calls
        //      YOUR callback function (if you specified one).
        //
        // 2.   Here, `this' is the Hunlock Ultimate Ajax Object created by:-
        //          theGreatKiwiAjaxFunction()
        //
        //      Ie:-
        //          this = <Hunlock Ultimate Ajax Object Instance>
        //
        //      As such it contains a lot of data about this Ajax call
        //      (amd how the server's response is to be handled).  Ie:-
        //
        //          this.greatKiwiAjaxFunction_requestDetails = {
        //              url                 :   http://www.example.com/[path/]
        //              params_as_input     :   <string or object>
        //              params_string_sent  :   "this=something&that=or-other"
        //              method              :   "get" | "post" (
        //              options             :   {} or {...}
        //              } ;
        //
        //      Where:-
        //
        //          this.greatKiwiAjaxFunction_requestDetails.options = {
        //              question_synchronous           : TRUE | FALSE
        //              fail_silently                  : TRUE | FALSE
        //              fail_silently_cleanup_function : null | function object
        //				show_response				   : true
        //              ok_or_error                    : TRUE | FALSE
        //              ok_or_error_cleanup_function   : null | function object
        // 				alert_function				   : null
        //              innerHTML_replace              : element id
        //              innerHTML_append               : element id
        //              innerHTML_prepend              : element id
        //              response_to                    : null | function object
        //              callback_function              : null | function object
        //              passthru_obj                   : null | {} | {...}
        //              }
        //
        // -------------------------------------------------------------------

//Debug( this.request_details , { depth : 10 } ) ;

        // -------------------------------------------------------------------
        // NOTE!
        // -----
        // this = my_hunlock_ultimate_ajax_object_instance
        // -------------------------------------------------------------------

        var request_details = this.greatKiwiAjaxFunction_requestDetails ;

        var request_options = request_details.options ;

        // -------------------------------------------------------------------
        // NOT 200 = OK ?
        // -------------------------------------------------------------------

        if (    statusCode !== 200
                &&
                request_options.fail_silently === false
            ) {

            // ---------------------------------------------------------------
            // NOTE!
            // =====
            // StatusCode 0 isn't documented very well.
            //
            // But it seems to occur if you violate the "same origin" policy
            // (and try to make Ajax requests to a different host).
            // ---------------------------------------------------------------

            var msg ;

            // ---------------------------------------------------------------

            if ( statusCode === 0 ) {

                // -----------------------------------------------------------
                // status === 0
                // -----------------------------------------------------------

                msg =   'Ajax HTTP Request Error/Status Code 0'                 +   '\n\n'  +
                        'While trying to access:-'                              +   '\n'    +
                        '       URL: ' + request_details.url                    +   '\n'    +
                        'PARAMS: '     + request_details.params_string_sent     +   '\n'    +
                        'METHOD: '     + request_details.method                 +   '\n\n'  +
                        'This generally means that your browser has decided'    +   '\n'    +
                        'NOT to proceed with this HTTP/Ajax Request for some'   +   '\n'    +
                        'reason.'                                               +   '\n\n'  +
                        'Most likely, it\'s because the request violates the'   +   '\n'    +
                        '"same origin" policy.  In other words, it\'s to a'     +   '\n'    +
                        'a DIFFERENT server than that hosting the current'      +   '\n'    +
                        'web page.' ;

                // -----------------------------------------------------------

            } else {

                // -----------------------------------------------------------
                // 'Normal' HTTP Error!
                // -----------------------------------------------------------

                msg =   'Ajax HTTP Request ERROR: ' + statusCode + ' - ' + statusText   +   '\n\n'  +
                        'While trying to access:-'                                      +   '\n'    +
                        '       URL: ' + request_details.url                            +   '\n'    +
                        'PARAMS: '     + request_details.params_string_sent             +   '\n'    +
                        'METHOD: '     + request_details.method ;

                // -----------------------------------------------------------

            }

            // ---------------------------------------------------------------

            alert( msg ) ;

            // ---------------------------------------------------------------

            if ( typeof request_options.fail_silently_cleanup_function === 'function' ) {

                request_options.fail_silently_cleanup_function(
                    this                ,
                    statusCode          ,
                    statusText          ,
                    responseText        ,
                    responseXML
                    ) ;

            }

            // ---------------------------------------------------------------

            return ;

            // ---------------------------------------------------------------

        }

        // -------------------------------------------------------------------
        // show_response ?
        // -------------------------------------------------------------------

        if ( request_options.show_response === true ) {

            // ---------------------------------------------------------------

            var msg

            // ---------------------------------------------------------------

            if ( responseText === '' ) {

                msg = 	'The server responded to your Ajax "' +
                    	request_details.method +
                    	'" request to:-\n' +
                    	'\t' + request_details.url ;

             	if ( request_details.params_string_sent !== '' ) {
                    msg += '?' + request_details.params_string_sent ;
                }

                msg += '\n\n' + 'but with an EMPTY (= invisible) STRING ("")' ;

            } else {

                msg = theGreatKiwiAjaxFunction_trim12( responseText ) ;

            	if ( msg === '' ) {

                	msg = 	'The server responded to your Ajax "' +
                    		request_details.method +
                    		'" request to:-\n' +
                    		'\t' + request_details.url ;

             		if ( request_details.params_string_sent !== '' ) {
                    	msg += '?' + request_details.params_string_sent ;
                	}

                    msg += 	'\n\n' +
                    		'but with ' +
                        	responseText.length +
                        	' (invisible) `white space\' characters.' ;

                }

            }

            // ---------------------------------------------------------------

            if ( typeof request_options.alert_function === 'function' ) {
                request_options.alert_function( msg ) ;

            } else {
	           	alert( msg ) ;

            }

            // ---------------------------------------------------------------

//          return ;
                //  Sometimes (if not always), you want to carry on processing
                //  (the rest of the response handler), after the
                //  "show_response" alert box has popped up.
                //
                //  But it's also possible that sometimes you want the
                //  response handler to exit - after the "show_response"
                //  alert box has popped up.  So maybe we should have
                //  a "show_response_then_exit" option too?

            // ---------------------------------------------------------------

        }

        // -------------------------------------------------------------------
        // ok_or_error ?
        // -------------------------------------------------------------------

        if (    request_options.ok_or_error === true
                &&
                responseText !== '--OK--'
            ) {

            // ---------------------------------------------------------------

           if ( typeof request_options.alert_function === 'function' ) {
                request_options.alert_function( responseText ) ;

            } else {
	           	alert( responseText ) ;

            }

            // ---------------------------------------------------------------

            if ( typeof request_options.ok_or_error_cleanup_function === 'function' ) {

                request_options.ok_or_error_cleanup_function(
                    this                ,
                    statusCode          ,
                    statusText          ,
                    responseText        ,
                    responseXML
                    ) ;

            }

            // ---------------------------------------------------------------

            return ;

            // ---------------------------------------------------------------

        }

        // -------------------------------------------------------------------
        // innerHTML_replace
        // innerHTML_append
        // innerHTML_prepend
        // -------------------------------------------------------------------

        var el ;

        // -------------------------------------------------------------------
        // innerHTML_replace
        // -------------------------------------------------------------------

        if ( request_options.hasOwnProperty( 'innerHTML_replace' ) ) {

            el = document.getElementById( request_options.innerHTML_replace ) ;

            if ( ! el ) {

                alert( great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_replace"'
                        ) ) ;

                return ;

            }

            el.innerHTML = responseText ;

        }

        // -------------------------------------------------------------------
        // innerHTML_append
        // -------------------------------------------------------------------

        if ( request_options.hasOwnProperty( 'innerHTML_append' ) ) {

            el = document.getElementById( request_options.innerHTML_append ) ;

            if ( ! el ) {

                alert( great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_append"'
                        ) ) ;

                return ;

            }

            el.innerHTML = responseText ;

        }

        // -------------------------------------------------------------------
        // innerHTML_prepend
        // -------------------------------------------------------------------

        if ( request_options.hasOwnProperty( 'innerHTML_prepend' ) ) {

            el = document.getElementById( request_options.innerHTML_prepend ) ;

            if ( ! el ) {

                alert( great_kiwi_ajax_function_failure(
                        'There is NO element with the ID specified by "innerHTML_prepend"'
                        ) ) ;

                return ;

            }

            el.innerHTML = responseText ;

        }

        // -------------------------------------------------------------------
        // response_to
        // -------------------------------------------------------------------

        if ( typeof request_options.response_to === 'function' ) {

            request_options.response_to(
                responseText                                                    ,
                responseXML                                                     ,
                this.greatKiwiAjaxFunction_requestDetails.options.passthru_obj
                ) ;

        }

        // -------------------------------------------------------------------
        // callback_function
        // -------------------------------------------------------------------

        if ( typeof request_options.callback_function === 'function' ) {

            request_options.callback_function(
                this                ,
                statusCode          ,
                statusText          ,
                responseText        ,
                responseXML
                ) ;

        }

        // -------------------------------------------------------------------

    }

// ===========================================================================
// theGreatKiwiAjaxFunction_trim12()
// ===========================================================================

function theGreatKiwiAjaxFunction_trim12( str ) {
    //	See: http://blog.stevenlevithan.com/archives/faster-trim-javascript
	var	str = str.replace(/^\s\s*/, ''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

// ===========================================================================
// my_fail_silently_cleanup_function()
// my_ok_or_error_cleanup_function()
// my_callback_function()
// ===========================================================================

// ---------------------------------------------------------------------------
// NOTE!
// -----
// The following is a template and some docs for the "callback_function"
// (that you can optionally specify, to handle the response from the server).
// ---------------------------------------------------------------------------

/*
    function my_fail_silently_cleanup_function(
    function my_ok_or_error_cleanup_function(
    function my_callback_function(
        my_hunlock_ultimate_ajax_object_instance    ,
        statusCode                                  ,
        statusText                                  ,
        responseText                                ,
        responseXML
        ) {

        // -------------------------------------------------------------------
        // NOTE!
        // -----
        // my_hunlock_ultimate_ajax_object_instance contains a lot of data
        // about the Ajax call whoose response this cleanup/callback function
        // is handling - as well as the details of how that response is to be
        // handled).  Ie:-
        //
        //      this.greatKiwiAjaxFunction_requestDetails = {
        //          url                 :   http://www.example.com/[path/]
        //          params_as_input     :   <string or object>
        //          params_string_sent  :   "this=something&that=or-other"
        //          method              :   "get" | "post" (
        //          options             :   {} or {...}
        //          } ;
        //
        // Where:-
        //
        //      this.greatKiwiAjaxFunction_requestDetails.options = {
        //          question_synchronous           : TRUE | FALSE
        //          fail_silently                  : TRUE | FALSE
        //          fail_silently_cleanup_function : null | function object
        //          ok_or_error                    : TRUE | FALSE
        //          ok_or_error_cleanup_function   : null | function object
        //          callback_function              : null | function object
        //          passthru_obj                   : null | {} | {...}
        //          }
        //
        // -------------------------------------------------------------------

        var request_details = my_hunlock_ultimate_ajax_object_instance[
                                'greatKiwiAjaxFunction_requestDetails'
                                ] ;

        var request_options = request_details.options ;

        // -------------------------------------------------------------------

        ...your cleanup or response handling code goes here...

        // -------------------------------------------------------------------

    }
*/

// ===========================================================================
// my_response_to_function()
// ===========================================================================

// ---------------------------------------------------------------------------
// NOTE!
// -----
// The following is a template and some docs for the "response_to" function
// (that you can optionally specify, to handle the response from the server).
// ---------------------------------------------------------------------------

/*
    function my_response_to_function(
        responseText    ,
        responseXML     ,
        passthru_obj
        ) {

        // -------------------------------------------------------------------
        // my_response_to_function(
        //      responseText    ,
        //      responseXML     ,
        //      passthru_obj
        //      )
        // - - - - - - - - - - - -
        // RETURNS nothing (any response is ignored).
        //
        // (See "callback_function" if you need a more powerful callback
        // function.)
        // -------------------------------------------------------------------

        ...your cleanup or response handling code goes here...

        // -------------------------------------------------------------------

    }
*/

