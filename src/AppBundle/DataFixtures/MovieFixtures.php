<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $genreRepository = $manager->getRepository('AppBundle:Genre');

        $genre1 = $genreRepository->findOneBy(['name' => 'komedia romantyczna']);
        $genre2 = $genreRepository->findOneBy(['name' => 'sensacyjny']);
        $genre3 = $genreRepository->findOneBy(['name' => 'komedia']);

        $movie1 = new Movie();
        $movie1
            ->setTitle('Kobieta sukcesu')
            ->setDescription('Główną bohaterką filmu jest Mańka (Agnieszka Więdłocha), szefowa firmy w wielkim mieście, której życie nagle wywraca się do góry nogami. Jej biznes pada ofiarą nieuczciwej konkurencji, związek z Norbertem (Mikołaj Roznerski) przeżywa kryzys, a pod drzwiami mieszkania kobieta zastaje Lilkę (Julia Wieniawa), młodszą siostrę uosabiającą chaos, tak obcy perfekcyjnej Mańce. W jej życie – za sprawą psa i przypadku – wkracza również Piotr (Bartosz Gelner), którego wbrew sobie i mimo serii nieporozumień zdaje się przyciągać. Jako przebojowa kobieta sukcesu Mańka nie zamierza się poddawać i skupia się na walce o przetrwanie firmy i zdemaskowanie oszustów. Czy nie straci przez to z oczu siostrzanej przyjaźni i szansy na miłość? „Kobieta sukcesu” to lekka i przewrotna komedia romantyczna o tym, że kiedy wydawać by się mogło, że straciliśmy wszystko, tak naprawdę dostajemy od losu to, co najcenniejsze.')
            ->setGenre($genre1)
            ->setCast('Agnieszka Więdłocha, Mikołaj Roznerski, Bartosz Gelner')
            ->setDirector('Robert Wichrowski')
            ->setCountry('Polska')
            ->setAgeRestrictions('12+')
            ->setReleaseDate(new \DateTime('2018-03-08'))
            ->setCoverImage('https://i.datapremiery.pl/1/000/14/896/kobieta-sukcesu-cover-okladka.jpg')
            ->setTrailerYoutubeUrl('https://www.youtube.com/embed/4f_xnB5a7Cs');

        $movie2 = new Movie();
        $movie2
            ->setTitle('Pitbull: Ostatni pies')
            ->setDescription('Kiedy ginie Soczek, partner Majamiego, policjanci z wydziału terroru rozpoczynają dochodzenie. Schwytanie sprawcy uważają nie tylko za swój obowiązek, ale też punkt honoru. Wydział jest przetrzebiony zmianami organizacyjnymi i zwolnieniami. W tej sytuacji, aby stawić czoła gangsterom, stołeczny komendant ściąga do Warszawy rozproszonych po prowincji, doświadczonych policjantów. W stolicy pojawiają się Despero (Marcin Dorociński), Metyl (Krzysztof Stroiński) oraz – prosto z Waszyngtonu – Nielat, zwany obecnie Quantico (Rafał Mohr). W walce o dominację nad miastem, toczonej między gangami z Pruszkowa i Wołomina, pojawia się trzeci, znaczący gracz – Czarna Wdowa (Dorota Rabczewska).')
            ->setGenre($genre2)
            ->setCast('Marcin Dorociński, Krzysztof Stroiński, Doda')
            ->setDirector('Władysław Pasikowski')
            ->setCountry('Polska')
            ->setAgeRestrictions('16+')
            ->setReleaseDate(new \DateTime('2018-03-15'))
            ->setCoverImage('https://i.datapremiery.pl/1/000/16/196/pitbull-ostatni-pies-cover-okladka.jpg')
            ->setTrailerYoutubeUrl('https://www.youtube.com/embed/i8p0LIwzzRc');

        $movie3 = new Movie();
        $movie3
            ->setTitle('Gotowi na wszystko. Exterminator ')
            ->setDescription('Piątka przyjaciół postanawia reaktywować swój dawny zespół o nazwie Exterminator. Pani burmistrz obiecuje im w tym pomóc dając dotację.')
            ->setGenre($genre3)
            ->setCast('Paweł Domagała, Krzysztof Czeczot, Piotr Żurawski')
            ->setDirector('	Michał Rogalski')
            ->setCountry('Polska')
            ->setAgeRestrictions('12+')
            ->setReleaseDate(new \DateTime('2018-01-05'))
            ->setCoverImage('https://i.datapremiery.pl/1/000/14/277/gotowi-na-wszystko-exterminator-cover-okladka.jpg')
            ->setTrailerYoutubeUrl('https://www.youtube.com/embed/Nr1ZtM--opw');

        $manager->persist($movie1);
        $manager->persist($movie2);
        $manager->persist($movie3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [GenreFixtures::class];
    }
}