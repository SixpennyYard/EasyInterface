<?php

namespace SixpennyYard\EasyInterface\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use SixpennyYard\EasyInterface\exception\FormName;
use SixpennyYard\EasyInterface\FormManager;

class FormCommand extends Command
{
    /**
     * @var string
     */
    protected string $commandName;
    /**
     * @var string
     */
    protected string $commandDescription;
    /**
     * @var string
     */
    protected string $commandUsage;
    /**
     * @var string
     */
    protected string $sendForm;

    /**
     * @param string $name
     * @param string $description
     * @param string $usage
     * @param string $sendForm
     */
    public function __construct(string $name, string $description, string $usage, string $sendForm)
    {
        $this->commandName = $name;
        $this->commandDescription = $description;
        $this->commandUsage = $usage;
        $this->sendForm = $sendForm;

        parent::__construct($name, $description, $usage);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @throws FormName
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player)
        {
            FormManager::getInstance()->sendFormToPlayer($sender, $this->sendForm);
        }
    }

}