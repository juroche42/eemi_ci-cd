<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, unique: true)]
	private ?string $name = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $color = null;

	#[ORM\ManyToMany(targetEntity: Task::class, inversedBy: 'tags')]
	private Collection $tasks;

	public function __construct()
	{
		$this->tasks = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getColor(): ?string
	{
		return $this->color;
	}

	public function setColor(?string $color): self
	{
		$this->color = $color;

		return $this;
	}

	/**
	 * @return Collection<int, Task>
	 */
	public function getTasks(): Collection
	{
		return $this->tasks;
	}

	public function addTask(Task $task): self
	{
		if (!$this->tasks->contains($task))
			$this->tasks->add($task);

		return $this;
	}

	public function removeTask(Task $task): self
	{
		$this->tasks->removeElement($task);

		return $this;
	}
}
