<?php
	/**
	 * ORM testing
	 *
	 * @author Mike Chip
	 */
	 
	namespace Controller;
	
	class Ormtest
	{
		function actionIndex()
		{
			$i = \Database\ORM::i();
			$d = $i->table('online')->rows(array('ip' => '127.0.0.1'));
			$return = '';
			
			foreach($d as $w => $a)
			{
				foreach($a as $k => $v)
				{
					$return .= '<p>'.$k.' = '.$v.'</p>';
				}
				$return .= '<hr>';
			}
			
			return (!empty($return) ? $return : 'ERROR');
		}
		
		function actionAdvanced()
		{
			$i = \Database\ORM::i();
			$d = $i->table('online')->wheres('ip != 0', 'id >= 1');

			$return = '';
			
			foreach($d as $w => $a)
			{
				foreach($a as $k => $v)
				{
					$return .= '<p>'.$k.' = '.$v.'</p>';
				}
				$return .= '<hr>';
			}
			
			return (!empty($return) ? $return : 'ERROR');
		}
		
		function actionSavetest()
		{
			$i = \Database\ORM::i();
			$d = $i->table('online')->where('ip != 0', 'id >= 1');

			$return = "IP: {$d->ip}. It was changed. Refresh the page";
			
			$d->ip = '127.0.0.2';
			$d->save();
			
			return (!empty($return) ? $return : 'ERROR');
		}
	}