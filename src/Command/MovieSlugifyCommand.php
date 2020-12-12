<?php

namespace App\Command;


use App\Repository\MovieRepository;
use App\Services\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieSlugifyCommand extends Command
{
    protected static $defaultName = 'app:movie:slugify';

    private $em;
    private $movieRepository;
    private $slugger;

    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository, Slugger $slugger)
    {
        parent::__construct();
        
        $this->em=$em;
        $this->movieRepository=$movieRepository;
        $this->slugger=$slugger;
    }

    protected function configure()
    {
        $this
            ->setDescription('Génère le slug pour tous les films')
            ->addArgument('movieId', InputArgument::OPTIONAL, 'Id d\'un film dont on veut calculer le slug')
            ->addOption('slug', null, InputOption::VALUE_REQUIRED, 'Le slug exact qu\'on veut pour un film')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // $arg1 = $input->getArgument('arg1');

        $movieId= $input->getArgument('movieId');
        
        
        if ($movieId) {

            //$io->note(sprintf('You passed an argument: %s', $movieId));
            $movie=$this->movieRepository->find($movieId);

            if ($movie==null){
                throw new \Exception('Aucun film n\'existe en base de donnée avec cet id.');
            }

            $exactSlug=$input->getOption('slug');

            if ($exactSlug) {
               $movie->setSlug($exactSlug);
            } else{

                $movie->setSlug($this->slugger->slugify($movie->getTitle()));
            }

            $this->em->flush();

            //dump($movie);

            return 0;
        }
        
        else{
            
            $movies=$this->movieRepository->findAll();
            foreach($movies as $movie){
    
                $movie->setSlug($this->slugger->slugify($movie->getTitle()));
            }
        }
        


        $this->em->flush();
        

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        // echo 'le message que je veux'.PHP_EOL;

        return 0;
    }
}

