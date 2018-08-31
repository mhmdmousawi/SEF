<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
    
        <script>

            var socket;


            function createSocket(host) {

                //if ('WebSocket' in window)
                    return new WebSocket(host);
                //else if ('MozWebSocket' in window)
                //    return new MozWebSocket(host);

                //throw new Error("No web socket support in browser!");
            }

            function init() {
                var host = "ws://localhost:12345/chat";
                try {
                    socket = createSocket(host);
                    log('WebSocket - status ' + socket.readyState);
                    socket.onopen = function(msg) {
                        log("Welcome - status " + this.readyState);
                    };
                    socket.onmessage = function(msg) {
                        log(msg.data);
                    };
                    socket.onclose = function(msg) {
                        log("Disconnected - status " + this.readyState);
                    };
                }
                catch (ex) {
                    log(ex);
                }
                document.getElementById("msg").focus();
            }

            function send() {
                var msg = document.getElementById('msg').value;

                try {
                    socket.send(msg);
                } catch (ex) {
                    log(ex);
                }
            }
            function quit() {//let it be on logout
                log("Goodbye!");
                socket.close();
                socket = null;
            }

            function log(msg) {
                document.getElementById("log").innerHTML += "<br>" + msg;
            }
            function onkey(event) {
                if (event.keyCode == 13) {
                    send();
                }
            }
        </script> 
    </head>
    
    <body onload="init()">
        <h3>WebSocket Test</h3>
        <div id="log"></div>
        <label>Message <input id="msg" type="text" onkeypress="onkey(event)"/></label>
        <button onclick="send()">Send</button>
        <button onclick="quit()">Quit</button>
        <div>Server will echo your response!</div>
    </body>
</html>
