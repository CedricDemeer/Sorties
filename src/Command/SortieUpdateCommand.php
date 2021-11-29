<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SortieUpdateCommand extends Command
{
// the name of the command (the part after "bin/console")
protected static $defaultName = 'app:update-date-sorties';


    protected function configure()
    {
        $this->setName('books')
            ->setDescription('Shows books in a table')
            ->setHelp('This command demonstrates the usage of a table helper');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);

        $table->setHeaderTitle('Books')
            ->setHeaders(['Title', 'ISBN', 'Author', 'Publisher'])
            ->setRows([
                ['Java Language Features', '978-1-4842-3347-4', 'Kishori Sharan', 'Apress' ],
                ['Python Testing with pytest', '978-1-68-050-240-4', 'Brian Okken', 'The Pragmatic Programmers' ],
                ['Deep Learning with Python', '978-1-61729-443-3', 'Francois Chollet', 'Manning' ],
                ['Laravel up & Running', '978-1-491-93698-5', 'Matt Stauffer', 'O\'Reilly' ],
                ['Sams Teach Yourself TCP/IP', '978-0-672-33789-5', 'Joe Casad', 'SAMS' ]
            ]);

        $table->render();


return Command::SUCCESS;

// or return this if some error happened during the execution
// (it's equivalent to returning int(1))
// return Command::FAILURE;
}
}