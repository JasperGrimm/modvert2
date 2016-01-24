<?php
/**
 * Created by PhpStorm.
 * User: vestnik
 * Date: 1/24/2016
 * Time: 2:54 AM
 */

namespace Modvert\Commands;


use Modvert\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ModvertCommand extends Command
{
    protected $name;

    protected $description;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var InputInterface
     */
    protected $input;


    protected function ask($question_message, $default='no')
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new Question($question_message, $default);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->app = Application::getInstance();
        $this->output = new ConsoleOutput();
        $this->input = new ArgvInput();
        $this->app->setOutput($this->output);
        $this->setName($this->name)
            ->setDescription($this->description)
            ->addOption(
                'stage',
                's',
                InputOption::VALUE_OPTIONAL,
                'Remote stage',
                $this->app->config()->get('default_stage')
            )
        ;
    }

}