<?php

namespace EasyWorkflowBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->addOption('total', '-t', InputOption::VALUE_REQUIRED)
            ->setName('easy_workflow:demo_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 1; $i <= $input->getOption('total'); $i++) {
            $output->write("\r$i/{$input->getOption('total')}");
            usleep(30000);
        }
        $output->write(PHP_EOL);
    }
}
