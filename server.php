<?php

$host = "127.0.0.1";
$port = 20224;
set_time_limit(0);

// Create socket
$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// Bind socket to address and port
$result = socket_bind($sock, $host, $port) or die("Could not bind socket\n");

// Start listening for incoming connections
$result = socket_listen($sock, 5) or die("Could not listen on socket\n");
echo "Server listening on $host:$port...\n";

class Chat
{
    function readline()
    {
        return rtrim(fgets(STDIN));
    }
}

do {
    // Accept incoming connection
    $accept = socket_accept($sock) or die("Could not accept incoming connection.\n");

    // Read message from client
    $msg = socket_read($accept, 1024) or die("Could not read input\n");
    $msg = trim($msg);
    echo "Client says: $msg\n\n";

    // Get reply from server
    $line = new Chat();
    echo "Enter Reply: ";
    $reply = $line->readline();

    // Send reply to client
    socket_write($accept, $reply, strlen($reply)) or die("Could not write output\n");

    // Close the connection to the client after handling
    socket_close($accept);
} while (true);

// Close the server socket (this line is unreachable because the loop is infinite)
socket_close($sock);
?>
