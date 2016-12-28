<?php

namespace AppBundle\Command;

use AppBundle\Entity\User\SuperAdminUser as Admin;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAdminCommand extends Command
{
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(UserPasswordEncoder $encoder, Registry $doctrine, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->encoder = $encoder;
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of Admin')
            ->addArgument('password', InputArgument::REQUIRED, 'Password of Admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $admin = new Admin();
        $admin->setEmail($email);
        $admin->setName('superadmin');
        $admin->setPlainPassword($password);
        $admin->setPassword($this->encoder->encodePassword($admin, $password));
        
        if (count($errors = $this->validator->validate($admin)) > 0) {
            $output->writeln((string)$errors);
        } else {
            $this->doctrine->getManager()->persist($admin);
            $this->doctrine->getManager()->flush();
            $output->writeln('Done.');
        }
    }
}
