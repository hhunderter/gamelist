<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Games\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'games',
        'version' => '1.0',
        'icon_small' => 'fa-gamepad',
        'author' => 'Veldscholten, Kevin',
        'link' => 'http://ilch.de',
        'languages' => [
            'de_DE' => [
                'name' => 'Spieleliste',
                'description' => 'Hier kannst du die Spieleliste verwalten.',
            ],
            'en_EN' => [
                'name' => 'Game list',
                'description' => 'Here you can manage the game list.',
            ],
        ],
        'ilchCore' => '2.1.15',
        'phpVersion' => '5.6'
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
    }

    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_games`;
            DROP TABLE `[prefix]_games_entrants`;');
        $this->db()->queryMulti("DELETE FROM `[prefix]_modules_folderrights` WHERE `key` = 'games';");
    }

    public function getInstallSql()
    {
        $installSql =
            'CREATE TABLE IF NOT EXISTS `[prefix]_games` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(100) NOT NULL,
                `image` VARCHAR(255) NULL DEFAULT NULL,
                `show` TINYINT(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;

            CREATE TABLE IF NOT EXISTS `[prefix]_games_entrants` (
                `game_id` INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            INSERT INTO `[prefix]_modules_folderrights` (`key`, `folder`) VALUES ("games", "static/upload/image");';

        return $installSql;
    }

    public function getUpdate($installedVersion)
    {

    }
}
