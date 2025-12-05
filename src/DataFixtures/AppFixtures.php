<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Booking;
use App\Entity\Optional;
use App\Entity\EventType;
use App\Entity\TypeOption;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // On instancie Faker pour générer des données aléatoires en français
        $faker = Factory::create('fr_FR');

        // On crée un tableau contenant les noms des typeoptions
        $typeOptions = ['Software', 'Hardware', 'Ergonomie'];

        // On crée un tableau vide qui contiendra tous les objets TypeOption créés ici
        $objectTypeOptions = [];

        // On boucle sur chaque élément du tableau $typeOptions
        // pour créer un objet TypeOption et l'ajouter au tableau $objectTypeOptions
        // puis on persiste chaque objet TypeOption
        foreach ($typeOptions as $item) {
            $typeOption = new TypeOption();
            $typeOption->setName($item);
            $objectTypeOptions[] = $typeOption;
            $manager->persist($typeOption);
        }
        // dd($objectTypeOptions);

        // On crée un tableau vide qui contiendra tous les objets Option créés ici
        $objectOptionals = [];

        // On boucle sur 30 éléments pour créer 30 objets Option
        // et les ajouter au tableau $objectOptions
        // puis on persiste chaque objet Option

        $tabSoft = ['pack Office', 'pack Adobe', 'pack Video', 'pack Audio'];
        $tabHard = ['PC', 'Retroprojecteur', 'Sono', 'Tableau blanc'];
        $tabErgo = ['Accès PMR', 'Climatisation', 'Lumière naturelle', 'Parking'];

        for ($i=0; $i < 3; $i++) { 
            for($j=0; $j<4; $j++){
                $optional = new Optional();
                $optional->setType($objectTypeOptions[$i]);
                if($i == 0){
                    $optional->setName($tabSoft[$j]);
                }elseif($i == 1){
                    $optional->setName($tabHard[$j]);
                }else{
                    $optional->setName($tabErgo[$j]);
                }
                $optional->setDescription($faker->sentence());
                $objectOptionals[] = $optional;
                $manager->persist($optional);

            }
        }

           // On crée un tableau vide qui contiendra tous les objets Room créés ici
           $objectRooms = [];

           // On boucle sur 10 éléments pour créer 10 objets Room
           // et les ajouter au tableau $objectRooms
           // puis on persiste chaque objet Room
           for ($i=0; $i < 20; $i++) { 
               $room = new Room();
               $room->setName($faker->word());
               $room->setAddress($faker->address());
               $room->setCapacity($faker->numberBetween(1, 100));
               $room->setDayPrice($faker->randomFloat(2, 50, 500));
               $room->setIsRentable($faker->boolean());
               $room->setPicture('/images/salle_' . ($i + 1) . '.jpg');
               // On génère un nombre aléatoire entre 1 et 5
               // qui déterminera le nombre d'options à ajouter à la salle
               $max = rand(1, 5);
               // On crée un tableau vide qui contiendra les index des options à ajouter
               $k = [];
               // On boucle sur $max éléments pour ajouter $max options à la salle
               for ($j=0; $j < $max; $j++) { 
                   $nb = $faker->numberBetween(0, count($objectOptionals) - 1);
                   // Si l'index $nb n'est pas déjà présent dans le tableau $k
                   if (!in_array($nb, $k)) {
                       // On ajoute l'index $nb au tableau $k
                       $k[] = $nb;
                       // On ajoute l'option correspondant à l'index $nb à la salle
                       $room->addOptional($objectOptionals[$nb]);
                   }
               }
               // On ajoute la salle au tableau $objectRooms
               $objectRooms[] = $room;
               //persist
               // On persiste la salle
               $manager->persist($room);
           }
   
           $tabEvents = ['Séminaire', 'Réunion', 'Conférence', 'Formation', 'Soirée', 'Autre'];
           // On crée un tableau vide qui contiendra tous les objets EventType créés ici
           $objectEventTypes = [];
   
           // On boucle sur 5 éléments pour créer 5 objets EventType  
           // et les ajouter au tableau $objectEventTypes
           // puis on persiste chaque objet EventType
           for ($i=0; $i < count($tabEvents); $i++) { 
               $eventType = new EventType();
               $eventType->setName($tabEvents[$i]);
               $eventType->setDescription($faker->sentence());
               $objectEventTypes[] = $eventType;
               $manager->persist($eventType);
           }
   
           // On crée un tableau contenant les noms des typeoptions
           $tabStatus = ['Disponible', 'Pré-réservée', 'Réservée', 'Annulée'];
           $tabColors = ['primary', 'warning','success', 'danger'];
           // On crée un tableau vide qui contiendra tous les objets Status créés ici
           $objectStatus = [];
   
           // On boucle sur 4 éléments pour créer 4 objets Status
           // et les ajouter au tableau $objectStatus
           // puis on persiste chaque objet Status
           for ($i=0; $i < count($tabStatus); $i++) { 
               $status = new Status();
               $status->setName($tabStatus[$i])
               ->setColor($tabColors[$i]);
               $objectStatus[] = $status;
               $manager->persist($status);
           }
   

           // On crée un tableau vide qui contiendra tous les objets User créés ici
              $objectUsers = [];
            
                // On boucle sur 20 éléments pour créer 20 objets User
                // et les ajouter au tableau $objectUsers
                // puis on persiste chaque objet User
                for ($i=0; $i < 10; $i++) { 
                    $user = new User();
                    $user->setEmail($faker->email());
                    $user->setPassword('$2y$13$focFB/V9Eus4uhQ6rw42deLwG.Db9aDlPjH3evnAwViSbBtHw3Fmu');
                    if($i == 7){
                        $user->setRoles(['ROLE_ADMIN']);
                    }else{
                        $user->setRoles(['ROLE_USER']);
                    }                   
                    $user->setAddress($faker->address());
                    $user->setName($faker->name());
                    $user->setPhone($faker->phoneNumber());
                    $user->setSerial($faker->siret());
                    $objectUsers[] = $user;
                    $manager->persist($user);
                }


           // On crée un tableau vide qui contiendra tous les objets Booking créés ici
           $objectBookings = [];
   
           // On boucle sur 20 éléments pour créer 20 objets Booking
           // et les ajouter au tableau $objectBookings
           // puis on persiste chaque objet Booking
   
           for ($i=0; $i < 20; $i++) { 
               $booking = new Booking();
               $booking->setUser($objectUsers[$faker->numberBetween(0, count($objectUsers) - 1)]);
               $booking->setEventType($objectEventTypes[$faker->numberBetween(0, count($objectEventTypes) - 1)]);
               $booking->setStatus($objectStatus[$faker->numberBetween(0, count($objectStatus) - 1)]);
               $booking->setStartDate($faker->dateTimeBetween('+1 days', '+5 days'));
               $nbDays = rand(1, 10);
               $booking->setEndDate($faker->dateTimeBetween('+1 week', '+2 weeks'));
               $booking->setComment($faker->sentence());
               $booking->setRoom($objectRooms[$faker->numberBetween(0, count($objectRooms) - 1)]);
               $total = $booking->getRoom()->getDayPrice() * $nbDays;
               $booking->setTotalPrice($total);
               $objectBookings[] = $booking;
               $manager->persist($booking);
           }

        


        $manager->flush();
    }
}
