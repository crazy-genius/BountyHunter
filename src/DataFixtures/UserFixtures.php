<?php

declare(strict_types=1);

namespace BountyHunter\DataFixtures;

use BountyHunter\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package BountyHunter\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $secondUser = new User();
        $user->setUsername('alex');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'some_pass'));
        $secondUser->setPassword($this->passwordEncoder->encodePassword($secondUser, 'some_second_pass'));
        $secondUser->setUsername('ustas');

        $manager->persist($user);
        $manager->persist($secondUser);

        $manager->flush();
    }
}
