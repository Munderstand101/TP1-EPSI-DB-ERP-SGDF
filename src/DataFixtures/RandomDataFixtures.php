<?php
namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Chief;
use App\Entity\Family;
use App\Entity\Group;
use App\Entity\Payment;
use App\Entity\PaymentType;
use App\Entity\Qualification;
use App\Entity\Role;
use App\Entity\Scout;
use App\Entity\Unit;
use App\Repository\ActivityRepository;
use App\Repository\FamilyRepository;
use App\Repository\GroupRepository;
use App\Repository\PaymentTypeRepository;
use App\Repository\QualificationRepository;
use App\Repository\RoleRepository;
use App\Repository\UnitRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class RandomDataFixtures extends Fixture
{
    private $groupRepository;
    private $unitRepository;
    private $familyRepository;
    private $activityRepository;
    private $paymentTypeRepository;
    private $qualificationRepository;
    private $roleRepository;

    public function __construct(GroupRepository $groupRepository,
                                UnitRepository $unitRepository,
                                FamilyRepository $familyRepository,
                                ActivityRepository $activityRepository,
                                PaymentTypeRepository $paymentTypeRepository,
                                QualificationRepository $qualificationRepository, RoleRepository $roleRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->unitRepository = $unitRepository;
        $this->familyRepository = $familyRepository;
        $this->activityRepository = $activityRepository;
        $this->paymentTypeRepository = $paymentTypeRepository;
        $this->qualificationRepository = $qualificationRepository;
        $this->roleRepository = $roleRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $totalRecords = 10000;
        $batchSize = 1000;

        $batchCount = ceil($totalRecords / $batchSize);

        for ($i = 0; $i < $batchCount; $i++) {
            $objects = [];

            for ($j = 0; $j < $batchSize; $j++) {
                // generate a random number between 1 and 10 to select a random entity
                $entityIndex = rand(1, 10);

                switch ($entityIndex) {
                    case 1:
                        $entity = new PaymentType();
                        $entity->setName($faker->sentence(2));
                        $entity->setMore($faker->paragraph(2));
                        break;

                    case 2:
                        $entity = new Qualification();
                        $entity->setName($faker->sentence(2));
                        $entity->setDescription($faker->paragraph(2));
                        break;
                    case 3:
                        $entity = new Role();
                        $entity->setName($faker->sentence(2));
                        $entity->setCode($faker->randomNumber(5));
                        $entity->setDescription($faker->paragraph(2));
                        break;
                    case 4:
                        $entity = new Group();
                        $entity->setName($faker->sentence(2));
                        $entity->setDescription($faker->paragraph(2));
                        break;
                    case 5:
                        $entity = new Family();
                        $entity->setInformation($faker->sentence(2));
                        break;
                    case 6:
                        $entity = new Activity();
                        $entity->setName($faker->paragraph(10));
                        $entity->setDescription($faker->paragraph(2));
                        $entity->setDate($faker->dateTimeBetween('-1 month', '+1 month'));
                        $entity->setDuration($faker->numberBetween(1, 8));
                        $entity->setLocation($faker->address());
                        $entity->setFee($faker->numberBetween(5, 50));
                        $entity->setMore($faker->sentence(2));

                        break;




                    // add more cases for other entities as needed
                    default:
                        $entity = new \App\Entity\Family();
                        $entity->setInformation($faker->sentence(2));
                        // set other properties as needed
                        break;
                }

                $objects[] = $entity;
            }

            foreach ($objects as $object) {
                $manager->persist($object);
            }

            $manager->flush();
            $manager->clear();
        }

        $this->loadA1($manager);
        $this->loadA2($manager);
    }

    public function loadA1(ObjectManager $manager)
    {
        $groups = $this->groupRepository->findAll();

        $faker = Factory::create();

        $totalRecords = 10000;
        $batchSize = 1000;

        $batchCount = ceil($totalRecords / $batchSize);

        for ($i = 0; $i < $batchCount; $i++) {
            $objects = [];

            for ($j = 0; $j < $batchSize; $j++) {



                        $entity = new Unit();
                        $entity->setName($faker->sentence(2));
                        $entity->setDescription($faker->paragraph(2));

                        $groups = $this->groupRepository->findAll();
                        if (!empty($groups)) {
                            $randomIndex = array_rand($groups);
                            $randomGroup = $groups[$randomIndex];
                            $entity->setGroup($randomGroup);
                        }



                $objects[] = $entity;
            }

            foreach ($objects as $object) {
                $manager->persist($object);
            }

            $manager->flush();
            $manager->clear();
        }
    }


    public function loadA2(ObjectManager $manager)
    {
        $groups = $this->groupRepository->findAll();

        $faker = Factory::create();

        $totalRecords = 10000;
        $batchSize = 1000;

        $batchCount = ceil($totalRecords / $batchSize);

        for ($i = 0; $i < $batchCount; $i++) {
            $objects = [];

            for ($j = 0; $j < $batchSize; $j++) {
                // generate a random number between 1 and 10 to select a random entity
                $entityIndex = rand(1, 10);

                switch ($entityIndex) {

                    case 1:
                        $entity = new Scout();
                        $entity->setFirstName($faker->firstName());
                        $entity->setLastName($faker->lastName());
                        $entity->setBirthday($faker->dateTimeThisCentury());
                        $entity->setPhoneNumber($faker->phoneNumber());
                        $entity->setEmail($faker->email());
                        $entity->setSignUpDate($faker->dateTimeThisYear());
                        $entity->setYear($faker->numberBetween(1, 12));
                        $entity->setGender($faker->randomElement(['M', 'F']));

                        $units = $this->unitRepository->findAll();
                       // dd($units);
                        if (!empty($units)) {
                            $randomIndex = array_rand($units);
                            $randomGroup = $units[$randomIndex];
                            $entity->setUnit($randomGroup); //$faker->randomElement($randomGroups)
                        }

                        $familles = $this->familyRepository->findAll();
                        if (!empty($familles)) {
                            $randomIndex2 = array_rand($familles);
                            $randomFamille = $familles[$randomIndex2];
                            $entity->setFamily($randomFamille); // randomly
                        }

                        $activities = $this->activityRepository->findAll();
                        if (!empty($activities)) {

                            $randomActivityIndex = array_rand($activities);
                            $randomActivity = $activities[$randomActivityIndex];
                            $entity->addActivity($randomActivity);
                        }

                        break;

                    case 2:
                        $entity = new Chief();
                        $entity->setFirstName($faker->firstName());
                        $entity->setLastName($faker->lastName());
                        $entity->setBirthday($faker->dateTimeThisCentury());
                        $entity->setPhoneNumber($faker->phoneNumber());
                        $entity->setEmail($faker->email());
                        $entity->setSignUpDate($faker->dateTimeThisYear());
                        $entity->setGender($faker->randomElement(['M', 'F']));

                        $units = $this->unitRepository->findAll();
                        if (!empty($units)) {
                            $randomIndex = array_rand($units);
                            $randomUnit = $units[$randomIndex];
                            $entity->setUnit($randomUnit);
                        }
                        $qualifications = $this->qualificationRepository->findAll();
                        if (!empty($qualifications)) {

                            $randomQualificationIndex = array_rand($qualifications);
                            $randomQualification = $qualifications[$randomQualificationIndex];
                            $entity->addQualification($randomQualification);
                        }
                        $roles = $this->roleRepository->findAll();
                        if (!empty($roles)) {
                            $randomRoleIndex = array_rand($roles);
                            $randomRole = $roles[$randomRoleIndex];
                            $entity->addRole($randomRole);
                        }
                    break;


                    default:
                        $entity = new Payment();
                        $entity->setPaymontDate($faker->dateTimeThisYear());
                        $entity->setAmount($faker->numberBetween(50, 1000));

                        $activities = $this->activityRepository->findAll();
                        if (!empty($activities)) {

                            $randomIndex3 = array_rand($activities);
                            $randomActivity = $activities[$randomIndex3];
                            $entity->setActivity($randomActivity);
                        }

                        $paymentsTypes = $this->paymentTypeRepository->findAll();
                            if (!empty($paymentsTypes)) {
                                $randomIndex4 = array_rand($paymentsTypes);
                                $randomPaymentsTypes = $paymentsTypes[$randomIndex4];
                                $entity->setPaymentType($randomPaymentsTypes);
                            }

                        $manager->persist($entity);
                        break;

                }

                $objects[] = $entity;
            }

            foreach ($objects as $object) {
                $manager->persist($object);
            }

            $manager->flush();
            $manager->clear();
        }
    }




}
