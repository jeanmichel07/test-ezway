<?php

namespace App\Test\Controller;

use App\Entity\Emprunt;
use App\Repository\EmpruntRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmpruntControllerTest extends WebTestCase
{
    /** @var KernelBrowser */
    private $client;
    /** @var EmpruntRepository */
    private $repository;
    private $path = '/emprunt/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Emprunt::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Emprunt index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'emprunt[livre]' => 'Testing',
            'emprunt[abonne]' => 'Testing',
        ]);

        self::assertResponseRedirects('/emprunt/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Emprunt();
        $fixture->setLivre('My Title');
        $fixture->setAbonne('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Emprunt');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Emprunt();
        $fixture->setLivre('My Title');
        $fixture->setAbonne('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'emprunt[livre]' => 'Something New',
            'emprunt[abonne]' => 'Something New',
        ]);

        self::assertResponseRedirects('/emprunt/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLivre());
        self::assertSame('Something New', $fixture[0]->getAbonne());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Emprunt();
        $fixture->setLivre('My Title');
        $fixture->setAbonne('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/emprunt/');
    }
}
