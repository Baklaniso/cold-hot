<?php

namespace ColdHot;

use cli;

class ConsoleApplication
{
    private GameController $controller;

    public function __construct()
    {
        $this->controller = new GameController();
    }

    public function run(array $argv): void
    {
        $options = $this->parseArguments($argv);

        switch ($options['mode']) {
            case 'new':
                $this->controller->startNewGame();
                break;
            case 'list':
                $this->controller->listGames();
                break;
            case 'replay':
                $this->controller->replayGame($options['id']);
                break;
            case 'help':
                $this->showHelp();
                break;
            default:
                $this->controller->startNewGame();
        }
    }

    private function parseArguments(array $argv): array
    {
        $mode = 'new';
        $id = null;

        for ($i = 1; $i < count($argv); $i++) {
            switch ($argv[$i]) {
                case '--new':
                case '-n':
                    $mode = 'new';
                    break;
                case '--list':
                case '-l':
                    $mode = 'list';
                    break;
                case '--replay':
                case '-r':
                    $mode = 'replay';
                    if (isset($argv[$i + 1])) {
                        $id = (int)$argv[++$i];
                    }
                    break;
                case '--help':
                case '-h':
                    $mode = 'help';
                    break;
            }
        }

        return ['mode' => $mode, 'id' => $id];
    }

    private function showHelp(): void
    {
        cli\line("Cold-Hot v2.0");
        cli\line("==================");
        cli\line("Usage:");
        cli\line("  --new, -n        Начать новую игру");
        cli\line("  --list, -l       Показать сохраненные игры");
        cli\line("  --replay, -r ID  Переиграть игру по ID");
        cli\line("  --help, -h       Показать инструкции");
    }
}
