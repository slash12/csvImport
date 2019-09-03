<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use League\Csv\Reader;
use App\Entity\TestEntity;


class CsvImportCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'csv:import';

    protected function configure()
    {
        $this
            ->setDescription('csv import to map to db');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->importCSV();
        $io->success('process completed');
    }

    public function importCSV()
    {
        $em = $this->getEntityManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $path = $this->getContainer()->get('kernel')->getProjectDir() . '\public\\';
        $reader = Reader::createFromPath($path . '\text.csv');
        $reader->setHeaderOffset(0);

        foreach ($reader as $r) {
            $sql = <<<SQL
              INSERT INTO `test_entity` (`eq_site_limit`, `hu_site_limit`) VALUES (:eq_limit, :hu_limit);
SQL;
            $stmt = $this->getContainer()->get('doctrine')->getManager()->getConnection()->prepare($sql);
            $stmt->execute(['eq_limit' => $r['eq_site_limit'], 'hu_limit' => $r['hu_site_limit']]);
        }
    }

    public function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getEntityManager();
    }
}
