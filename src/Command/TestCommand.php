<?php

namespace App\Command;

use App\Entity\Course;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $barology = (new Course())->setName('Barology');
        $bazology = (new Course())->setName('Bazology');
        $jim = (new Student())->setName('Jim')->addCourse($barology);
        $bob = (new Student())->setName('Bob')->addCourse($bazology)->addCourse($bazology);

        $this->em->persist($barology);
        $this->em->persist($bazology);
        $this->em->persist($jim);
        $this->em->persist($bob);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
