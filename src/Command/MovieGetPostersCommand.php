<?php

namespace App\Command;


use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieGetPostersCommand extends Command
{
    protected static $defaultName = 'app:movie:get-posters';

    private $em;
    private $movieRepository;

    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository)
    {
        parent::__construct();
        
        $this->em=$em;
        $this->movieRepository=$movieRepository;
    }



    protected function configure()
    {
        $this
            ->setDescription('Va récupérer tous les posters des films en base de données')
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $movies=$this->movieRepository->findAll();

        foreach($movies as $movie){
    
            $title=$movie->getTitle();

            $title=urlencode($title);

            $url='http://www.omdbapi.com/?apikey='.$_ENV['OMDB_KEY'].'&t='.$title;

            $json=file_get_contents($url);

            $omdbResult=json_decode($json);

            if(isset($omdbResult->Poster) && $omdbResult->Poster !="N/A" ){
                // dump($omdbResult->Poster);
                $image=file_get_contents($omdbResult->Poster);

                file_put_contents('public/posters/'.$movie->getId().'.jpg', $image);
            }

        }
        
        $io = new SymfonyStyle($input, $output);
        $io->success('Tous les posters pour les films en base de données ont été récupérés.');
        
        return Command::SUCCESS;
    }
}

// $arg1 = $input->getArgument('arg1');
// if ($arg1) {
//     $io->note(sprintf('You passed an argument: %s', $arg1));
// }

// if ($input->getOption('option1')) {
//     // ...
// }