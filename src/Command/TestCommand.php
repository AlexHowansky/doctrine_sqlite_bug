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
        $this->em->persist((new Course())->setName('Barology'));
        $this->em->persist((new Student())->setName('Jim'));
        $this->em->flush();

        $barology = $this->em->getRepository(Course::class)->findOneByName('Barology');
        $jim = $this->em->getRepository(Student::class)->findOneByName('Jim');
        $jim->addCourse($barology);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
