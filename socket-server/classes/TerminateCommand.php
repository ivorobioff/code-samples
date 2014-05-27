<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TerminateCommand extends AbstractCommand
{
	function execute()
	{
		fclose($this->_client->getConnection());
	}
}