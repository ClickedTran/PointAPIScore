<?php
declare(strict_types = 1);

namespace Ifera\pointapi\listeners;

use Ifera\pointapi\Main;
use Ifera\ScoreHud\event\PlayerTagUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;
use onebone\pointapi\event\point\PointChangedEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use function is_null;

class EventListener implements Listener{

	/** @var Main */
	private $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	public function onPointChange(PointChangedEvent $event){
		$username = $event->getUsername();

		if(is_null($username)){
			return;
		}

		$player = $this->plugin->getServer()->getPlayerByPrefix($username);

		if($player instanceof Player && $player->isOnline()){
			(new PlayerTagUpdateEvent($player, new ScoreTag("pointapiscore.point", (string) $event->getPoint())))->call();
		}
	}
}
