<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SocketServer 
{
	public function start()
	{
		$server = stream_socket_server("tcp://0.0.0.0:9900", $errn, $err);

		if (!$server) die("$err ($errn)\n");

		$clients = new ClientsList();
		$w = $e = null;

		$ping_manager = new PingManager();

		while (true)
		{
			$read = $clients->getAllConnections();
			$read[] = $server;

			$status = stream_select($read, $w, $e, 0, 200000);

			if ($status === false)
			{
				echo "Error getting stream data!!!\n";
				break;
			}

			if ($status > 0)
			{
				if (in_array($server, $read))
				{
					$client = new Client(stream_socket_accept($server, -1));
					$clients->add($client);

					echo "Client connected (".$client->getConnection().")\n";

					unset($read[array_search($server, $read)]);
				}

				foreach ($read as $conn)
				{
					$message = new ClientMessage(fread($conn, 10000));

					try
					{
						$clients
							->findByConnection($conn)
							->executeCommand($message);
					}
					catch (InvalidArgumentException $ex)
					{
						echo "Error reading the message >> ".(string) $message."\n";
					}
				}
			}

			$ping_manager->run($clients);
		}

		fclose($server);
	}
} 